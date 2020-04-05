<?php
class Post
{
  private $db;

  public function __construct()
  {
    $this->db = new Database;
  }


  // Find user by email
  public function getPosts()
  {
    $this->db->query('SELECT *,
                    posts.id as postId,
                    users.id as userId,
                    posts.created_at as postCreated,
                    users.created_at as userCreated
                    FROM posts
                    INNER JOIN users
                    ON posts.user_id = users.id
                    ORDER BY posts.created_at DESC
                    ');

    $results = $this->db->resultSet();

    return $results;
  }


  // Add post
  public function addPost($data)
  {
    $this->db->query('INSERT INTO posts (title, body, user_id) VALUES(:title, :body, :user_id)');
    // Bind values
    $this->db->bind(':title', $data['title']);
    $this->db->bind(':body', $data['body']);
    $this->db->bind(':user_id', $data['user_id']);

    // Execute
    if ($this->db->execute()) {
      return true;
    } else {
      return false;
    }
  }


  // Update post
  public function updatePost($data)
  {
    $this->db->query('UPDATE posts SET title = :title, body = :body WHERE id =:id');
    // Bind values
    $this->db->bind(':title', $data['title']);
    $this->db->bind(':body', $data['body']);
    $this->db->bind(':id', $data['id']);

    // Execute
    if ($this->db->execute()) {
      return true;
    } else {
      return false;
    }
  }

  // Get post
  public function getPostById($id)
  {
    $this->db->query('SELECT * FROM posts WHERE id =:id');
    // Bind values
    $this->db->bind(':id', $id);

    $row = $this->db->single();

    return $row;
  }

  // delete post
  public function deletePost($id)
  {
    $this->db->query('DELETE FROM posts WHERE id =:id');
    // Bind values
    $this->db->bind(':id', $id);

    // Execute
    if ($this->db->execute()) {
      return true;
    } else {
      return false;
    }
  }
}
