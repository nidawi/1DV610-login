<?php

namespace Login\model;

interface IForumDAO {

  public function createThread(Thread $thread, Post $body, Account $poster);
  public function createPost(Post $post, Thread $thread, Account $poster);

  public function getThreads() : array;
  public function getThread(string $id) : Thread;
  public function getThreadPosts(Thread $thread) : array;
  public function getPost(string $id) : Post;

  public function updateThread(Thread $oldThread, Thread $newThread);
  public function updatePost(Post $oldPost, Post $newPost);

  public function deleteThread(Thread $thread);
  public function deletePost(Post $post);
}