<?php

/**
 * -------------------------------------------------------------------------------
 * PoGo - Organize and Manage your Projects like a Chief
 * Copyright (c) 2014 by Florian BETIL <fbetil@gmail.com>
 *
 * This file is part of PoGo.
 *
 * PoGo is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * PoGo is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with PoGo.  If not, see <http://www.gnu.org/licenses/>.
 *
 * Authors:
 *
 * Florian BETIL : <fbetil@gmail.com>
 *
 * Thanks:
 *
 * David (http://php.net/manual/en/function.imap-fetchstructure.php#85486)
 * -------------------------------------------------------------------------------
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class PoGoImap {
    private $codeigniter;
    private $pogo;

    function __construct(&$pogo) {
        $this->codeigniter = & get_instance();
        $this->pogo = & $pogo;
    }

    function getMsg($mbox,$mid) {
        // input $mbox = IMAP stream, $mid = message id
        // output all the following
        $msg = array(
            'from'=>'',
            'subject'=>'',
            'date'=>'',
            'charset'=>'utf-8',
            'htmlmsg'=>array(),
            'plainmsg'=>array(),
            'attachments'=>array()
            );

        // HEADER
        $h = imap_header($mbox,$mid);
        // add code here to get date, from, to, cc, subject...
        $msg['from'] = $h->from[0]->mailbox."@".$h->from[0]->host;
        $msg['subject'] = $h->subject;
        $msg['date'] = DateTime::createFromFormat('D, d M Y H:i:s O', $h->date);

        // BODY
        $s = imap_fetchstructure($mbox,$mid);
        if (!isset($s->parts))  // simple
            $this->getPart($mbox, $mid, $msg, $s, 0);  // pass 0 as part-number
        else {  // multipart: cycle through each part
            foreach ($s->parts as $partno0=>$p)
                $this->getPart($mbox, $mid, $msg, $p, $partno0+1);
        }

        // ENCODE UTF8
        if ($msg['charset'] != 'utf-8'){
            $msg['subject'] = iconv_mime_decode($msg['subject'],0,"UTF-8"); 
            foreach ($msg['htmlmsg'] as &$htmlmsg) {
                $htmlmsg = utf8_encode($htmlmsg);
            }
            foreach ($msg['plainmsg'] as &$plainmsg) {
                $plainmsg = utf8_encode($plainmsg);
            }
        }

        // RETURN
        return $msg;
    }

    function getPart($mbox, $mid, &$msg, $p, $partno) {
        // $partno = '1', '2', '2.1', '2.1.3', etc for multipart, 0 if simple

        // DECODE DATA
        $data = ($partno)?
            imap_fetchbody($mbox,$mid,$partno):  // multipart
            imap_body($mbox,$mid);  // simple

        //Get mime
        $mimeheaders = array();
        preg_match("/Content-Type:\s*([^;]*);/mi", imap_fetchmime($mbox,$mid,$partno), $mimeheaders);
        $mime = (empty($mimeheaders)) ? 'application/octet-stream' : $mimeheaders[1];

        // Any part may be encoded, even plain text messages, so check everything.
        if ($p->encoding==4)
            $data = quoted_printable_decode($data);
        elseif ($p->encoding==3)
            $data = base64_decode($data);

        // PARAMETERS
        // get all parameters, like charset, filenames of attachments, etc.
        $params = array();
        if (isset($p->parameters))
            foreach ($p->parameters as $x)
                $params[strtolower($x->attribute)] = $x->value;
        if (isset($p->dparameters))
            foreach ($p->dparameters as $x)
                $params[strtolower($x->attribute)] = $x->value;

        // ATTACHMENT
        // Any part with a filename is an attachment,
        // so an attached text file (type 0) is not mistaken as the message.
        if (isset($params['filename']) || isset($params['name'])) {
            // filename may be given as 'Filename' or 'Name' or both
            $filename = ($params['filename'])? $params['filename'] : $params['name'];
            // filename may be encoded, so see imap_mime_header_decode()
            $msg['attachments'][] = array('mime'=>$mime, 'filename'=>$filename, 'content' => (binary) $data);  // this is a problem if two files have same name
        }

        // TEXT
        if ($p->type==0 && $data) {
            // Messages may be split in different parts because of inline attachments,
            // so append parts in array
            if (strtolower($p->subtype)=='plain') {
                $msg['plainmsg'][] = trim($data);
            }else{
                $msg['htmlmsg'][] = trim($data);
            }

            if(isset($params['charset'])) $msg['charset'] = $params['charset'];  // assume all parts are same charset
        }

        // EMBEDDED MESSAGE
        // Many bounce notifications embed the original message as type 2,
        // but AOL uses type 1 (multipart), which is not handled here.
        // There are no PHP functions to parse embedded messages,
        // so this just appends the raw source to the main message.
        elseif ($p->type==2 && $data) {
            $msg['plainmsg'][] = trim($data);
        }

        // SUBPART RECURSION
        if (isset($p->parts)) {
            foreach ($p->parts as $partno0=>$p2)
                $this->getPart($mbox, $mid, $msg, $p2, $partno.'.'.($partno0+1));  // 1.2, 1.2.1, etc.
        }
    }


}
        
