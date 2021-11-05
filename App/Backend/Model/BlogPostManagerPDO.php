<?php
namespace App\Backend\Model;
 
use Entity\BlogPosts;
 
class BlogPostManagerPDO extends BlogPostManager
{
  protected function add(BlogPosts $BlogPosts)
  {
    $request = $this->dao->prepare('INSERT INTO blog_posts SET admin_id = :admin_id, date_p = :date_p, title = :title, content = :content, media = :media, slug = :slug, created_at = NOW(), updated_at = NOW()');
    
    $request->bindValue(':admin_id', $BlogPosts->adminId());
    $request->bindValue(':date_p', $BlogPosts->dateP());
    $request->bindValue(':title', $BlogPosts->title());
    $request->bindValue(':content', $BlogPosts->content());
    $request->bindValue(':media', $BlogPosts->media());
    $request->bindValue(':slug', $BlogPosts->slug());
 
    $request->execute();
  }
 
  public function count()
  {
    return $this->dao->query('SELECT COUNT(*) FROM blog_posts')->fetchColumn();
  }
 
  public function delete($id)
  {
    $this->dao->exec('DELETE FROM blog_posts WHERE id = '.(int) $id);
  }
 
  public function getList($debut = -1, $limite = -1)
  {
    $request = 'SELECT id, admin_id, media, date_p, title, content, slug, created_at FROM blog_posts ORDER BY id DESC';
 
    if ($debut != -1 || $limite != -1)
    {
      $request .= ' LIMIT '.(int) $limite.' OFFSET '.(int) $debut;
    }
 
    $request = $this->dao->query($request);
    $request->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\BlogPosts');
 
    $blogPostsList = $request->fetchAll();

   /* foreach ($blogPostsList as $blogPost)
    {
      $blogPost->setCreatedAt(new \DateTime($blogPost->getCreatedAt()));
      $blogPost->setUpdatedAt(new \DateTime($blogPost->getUpdatedAt()));
    }*/
 
    $request->closeCursor();
 
    return $blogPostsList;
  }
 
  public function getUnique($id)
  {
    $request = $this->dao->prepare('SELECT id, admin_id, media, date_p, title, content, slug FROM blog_posts WHERE id = :id');
    $request->bindValue(':id', (int) $id, \PDO::PARAM_INT);
    $request->execute();
 
    $request->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\BlogPosts');
    $blogPost=$request->fetch();
    
    /*if ($blogPost)
    {
      $blogPost->setCreatedAt(new \DateTime($blogPost->getCreatedAt()));
      $blogPost->setUpdatedAt(new \DateTime($blogPost->getUpdatedAt()));
 
      return $blogPost;
    }*/
 
    return $blogPost;
  }
 
  protected function modify(BlogPosts $BlogPosts)
  {
    $request = $this->dao->prepare('UPDATE blog_posts SET admin_id = :admin_id, date_p = :date_p, title = :title, content = :content, media = :media, slug = :slug, updated_at = NOW() WHERE id = :id');
    
    $request->bindValue(':admin_id', $BlogPosts->adminId());
    $request->bindValue(':date_p', $BlogPosts->dateP());
    $request->bindValue(':title', $BlogPosts->title());
    $request->bindValue(':content', $BlogPosts->content());
    $request->bindValue(':media', $BlogPosts->media());
    $request->bindValue(':slug', $BlogPosts->slug());
    $request->bindValue(':id', $BlogPosts->id(), \PDO::PARAM_INT);
 
    $request->execute();
  }
}