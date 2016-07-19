<?php

///////////////////////////////////////////////////////////////////////////////////////
// Commentia controller                                                              //
// This file routes the functions to the relevant classes/controls the program flow. //
// It contains a blueprint of every publically accessible function.                  //
// Author: Alexander Gilburg                                                         //
///////////////////////////////////////////////////////////////////////////////////////


namespace Commentia\Controllers;

require_once __DIR__.'/../../../vendor/autoload.php';

use Commentia\Models\Comments;
use Commentia\Models\Members;
use Commentia\Lexicon\Lexicon;

class CommentiaController
{
    public $members;
    public $comments;
    public $params = array();

    /**
     * Initiates a new controller instance for the relevant pageid.
     *
     * @param string $pageid The page ID for the comments (see README.md)
     */
    public function __construct($pageid)
    {
        session_start();

        $real_pageid = (isset($_SESSION['pageid']) ? $_SESSION['pageid'] : $pageid);

        require_once __DIR__.'/../../data/config.php';

        Lexicon::load(LEX_LOCALE);

        if (isset($real_pageid)) {
            $this->comments = new Comments($real_pageid);
        } else {
            exit('Error: Page ID not set');
        }

        $this->members = new Members();

        $this->params = array();
        foreach ($_GET as $key => $value) {
            $this->params[$key] = $value;
        }

        $_SESSION['pageid'] = $pageid;
    }

    public function displayComments($is_ajax_request)
    {
        return $this->comments->displayComments($is_ajax_request);
    }

    public function createNewComment($content, $reply_path)
    {
        return $this->comments->createNewComment($content, $reply_path);
    }

    public function editComment($ucid, $reply_path, $content)
    {
        return $this->comments->editComment($ucid, $reply_path, $content);
    }

    public function deleteComment($ucid, $reply_path)
    {
        return $this->comments->deleteComment($ucid, $reply_path);
    }

    public function getCommentMarkdown($ucid, $reply_path)
    {
        return $this->comments->getCommentMarkdown($ucid, $reply_path);
    }

    public function getCommentData($ucid, $reply_path, $entry)
    {
        return $this->comments->getCommentData($ucid, $reply_path, $entry);
    }

    public function getMemberData($username, $entry)
    {
        return $this->members->getMemberData($username, $entry);
    }

    public function loginMember($username, $password)
    {
        return $this->members->loginMember($username, $password);
    }

    public function logoutMember()
    {
        return $this->members->logoutMember();
    }

    public function signUpMember($username, $password, $retyped_password, $email, $avatar_file)
    {
        return $this->members->signUpMember($username, $password, $retyped_password, $email, $avatar_file);
    }

    public function displayAuthForm()
    {
        return $this->members->displayAuthForm();
    }

    public function displaySignUpForm()
    {
        return $this->members->displaySignUpForm();
    }

    public function getPhrase($phrase)
    {
        return Lexicon::getPhrase($phrase);
    }
}
