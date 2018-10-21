<?php

namespace Forum\view;

class ForumLayout extends \Login\view\ViewTemplate {

  private $accountManager;
  
  private static $threadLink = "thread";
  private static $postLink = "post";

  public function __construct(\lib\SessionStorage $session, \Login\model\AccountManager $accountManager) {
    parent::__construct($session);
    $this->accountManager = $accountManager;
  }

  public function getThreadLink() : string {
    return self::$threadLink;
  }
  public function getPostLink() : string {
    return self::$postLink;
  }

  /**
   * Returns a link formatted to point at the thread base path.
   */
  public function getThreadPath() : string {
    return $this->getForumLink() . '&' . $this->getThreadLink();
  }
  /**
   * Returns a link formatted to point at the post base path.
   */
  public function getPostPath() : string {
    return $this->getForumLink() . '&' . $this->getPostLink();
  }

  /**
   * Returns a link formatted to point at a thread with the given id.
   */
  public function getSpecificThreadLink(string $id) : string {
    return $this->getThreadPath() . '=' . $id;
  }
  /**
   * Returns a link formatted to point at a thread with the given id.
   */
  public function getSpecificPostLink(string $id) : string {
    return $this->getPostPath() . '=' . $id;
  }

  public function getDateString(int $time) : string {
    // Uniform forum date format that can be changed in one place.
    return date("F jS, Y, g:i a", $time);
  }

  public function getHTML(string $body) : string {
    return '
    ' . $this->generateForumHeader() . '
    ' . $this->generateMenu() . '
    ' . $body . '
    ';
  }

  private function generateForumHeader() : string {
    return '
    <h1><a href="?' . $this->getForumLink() . '">Forum</a></h1>
    <p>' . $this->generateLoggedInAsHTML() . '</p>
    ';
  }

  private function generateLoggedInAsHTML() : string {
    $username = $this->accountManager->getLoggedInAccount()->getUsername();
    return $this->accountManager->isLoggedIn()
      ? 'Logged in as ' . $username . ' (' . $this->getAccountType() . ')'
      : 'Not logged in.';
  }

  private function getAccountType() : string {
    return $this->accountManager->getLoggedInAccount()->isAdmin()
      ? "admin"
      : "user";
  }

  private function generateMenu() : string {
    return '
    <div class="forumMenuContainer">
      <ul>
        <li><a href="?' . $this->getForumLink() . '">Home</a></li>
        ' . $this->getNewThreadLink() . '
      </ul>
    </div>
    ';
  }

  private function getNewThreadLink() : string {
    return $this->accountManager->isLoggedIn()
      ? '<li><a href="?' . $this->getThreadPath() . '">New Thread</a></li>'
      : '';
  }
}