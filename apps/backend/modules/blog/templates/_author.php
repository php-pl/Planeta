<?php echo $blog->getEmail() == '' ? $blog->getAuthor() : mail_to($blog->getEmail(), $blog->getAuthor()) ?>