<?php
adminIdspace Model;
 
use \Entity\BlogPosts;
 
class BlogPostsManagerPDO extends BlogPostsManager
{
  protected function add(BlogPosts $BlogPosts)
  {
    $request = $this->dao->prepare('INSERT INTO BlogPosts SET adminId = :adminId, dateP = :dateP, title = :title, content = :content, media = :media, slug = :slug, createdAt = NOW(), updatedAt = NOW()');
    
    $request->bindValue(':adminId', $BlogPosts->adminId());
    $request->bindValue(':dateP', $BlogPosts->dateP());
    $request->bindValue(':title', $BlogPosts->title());
    $request->bindValue(':content', $BlogPosts->content());
    $request->bindValue(':media', $BlogPosts->media());
    $request->bindValue(':slug', $BlogPosts->slug());
 
    $request->execute();
  }
 
  public function count()
  {
    return $this->dao->query('SELECT COUNT(*) FROM BlogPosts')->fetchColumn();
  }
 
  public function delete($id)
  {
    $this->dao->exec('DELETE FROM BlogPosts WHERE id = '.(int) $id);
  }
 
  public function getList($debut = -1, $limite = -1)
  {
    $request = 'SELECT id, adminId, media, dateP, title, content, slug FROM BlogPosts ORDER BY id DESC';
 
    if ($debut != -1 || $limite != -1)
    {
      $request .= ' LIMIT '.(int) $limite.' OFFSET '.(int) $debut;
    }
 
    $request = $this->dao->query($request);
    $request->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\BlogPosts');
 
    $BlogPostsList = $request->fetchAll();
 
    foreach ($listeBlogPosts as $BlogPosts)
    {
      $BlogPosts->setCreatedAt(new \DateTime($BlogPosts->createdAt()));
      $BlogPosts->setUpdatedAt(new \DateTime($BlogPosts->updatedAt()));
    }
 
    $request->closeCursor();
 
    return $BlogPostsList;
  }
 
  public function getUnique($id)
  {
    $request = $this->dao->prepare('SELECT id, adminId, media, dateP, title, content, slug FROM BlogPosts WHERE id = :id');
    $request->bindValue(':id', (int) $id, \PDO::PARAM_INT);
    $request->execute();
 
    $request->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\BlogPosts');
 
    if ($BlogPosts = $request->fetch())
    {
      $BlogPosts->setCreatedAt(new \DateTime($BlogPosts->createdAt()));
      $BlogPosts->setUpdatedAt(new \DateTime($BlogPosts->updatedAt()));
 
      return $BlogPosts;
    }
 
    return null;
  }
 
  protected function modify(BlogPosts $BlogPosts)
  {
    $request = $this->dao->prepare('UPDATE BlogPosts SET adminId = :adminId, dateP = :dateP, title = :title, content = :content, media = :media, slug = :slug, updatedAt = NOW() WHERE id = :id');
    
    $request->bindValue(':adminId', $BlogPosts->adminId());
    $request->bindValue(':dateP', $BlogPosts->dateP());
    $request->bindValue(':title', $BlogPosts->title());
    $request->bindValue(':content', $BlogPosts->content());
    $request->bindValue(':media', $BlogPosts->media());
    $request->bindValue(':slug', $BlogPosts->slug());
    $request->bindValue(':id', $BlogPosts->id(), \PDO::PARAM_INT);
 
    $request->execute();
  }
}