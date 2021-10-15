<?php
namespace App\Backend\Modules\BlogPost;

use \OCFram\BackController;
use \OCFram\HTTPRequest;
use \Entity\BloPost;

class BlogPostController extends BackController (HTTPRequest $request){

  public function executePostBlog(){
    if ($request->postExists('content'))
    {
        $slug = $this->app->user()->getAttribute('pseudo') .'-'. $request->getData('title');

        $blogPost = new Blogpost ([
        'adminId' => $this->app->user()->getAttribute('id'),
        'author' => $this->app->user()->getAttribute('pseudo'),
        'title' => $request->getData('title'),
        'content' => $request->postData('content')        
        'media' => $request->getData('media'),
        'slug' => $slug
        ]);

        $managerB = $this->managers->getManagerOf('blogPost');

        if($blogPost->isValid())
        {
            $managerB->save($blogPost);

            $this->app->user()->setFlash('Votre article est publié !');

            $this->app->httpResponse()->redirect('bootstrap.php?action=executeSeeBlog&id='.$request->getdata('id'));

        } else {

            $this->app->user()->setFlash('Entrez au moins un caractère autre q\'un espace pour valider chaque champ');
            $this->app->httpResponse()->redirect('bootstrap.php?action=executeBlogList');
        }
        
    } else {

        $this->page->addVar('title', 'Nouvelle publication');
    }  
  }

  public function executeModifyBlog(){
    $managerB = $this->managers->getManagerOf('blogPost');
    //modKey is a hidden field of the modify form to check if the user is submitting the form or is arriving on the view. Checking the actual field content won't wor for we'll put old values as default values
    if ($request->postExists('modKey')){
        $blogPost = new Blogpost ([
        'adminId' => $this->app->user()->getAttribute('id'),
        'author' => $this->app->user()->getAttribute('pseudo'),
        'title' => $request->getData('title'),
        'content' => $request->postData('content')        
        'media' => $request->getData('media'),
        'slug' => $request->postData('slug')
        ]);

        if($blogPost->isValid())
        {
            $managerB->save($blogPost);

            $this->app->user()->setFlash('Votre article a été mis à jour !');
            $this->app->httpResponse()->redirect('bootstrap.php?action=executeBlogList');

        } else {

            $this->app->user()->setFlash('Entrez au moins un caractère autre q\'un espace pour valider chaque champ');
            $this->app->httpResponse()->redirect('bootstrap.php?action=executeModifyBlog&id='.$request->getdata('id'));
        }
        
    } else {
        
        $blogPost = $managerB->getUnique($request->getdata('id'));

        $this->page->addVar('title', 'Editez votre article');
        $this->page->addVar('Blogpost', $blogPost);
    }       

  }

  public function executeDeleteBlog(){
    $managerB = $this->managers->getManagerOf('blogPost');
    $managerB->delete($request->getdata('id'));

    $this->app->httpResponse()->redirect('bootstrap.php?action=executeBlogList');
  }

  public function executeModerateComments(){
    $managerB = $this->managers->getManagerOf('blogPost');
    $managerC = $this->managers->getManagerOf('comments');

    if ($request->postExists('verdicts')){
      $verdicts = $request->postExists('verdicts');
      foreach($verdicts as $v){
        $comment = $managerC->getUnique($v[1]);

        if($v[0] == ok){
          $comment->setValidated(true);

          //mailer pour prévenir le subscriber
        }else{
          $comment->setValidated(false);

          //mailer pour prévenir le subscriber
        }
      }

      $managerC->save($comment);
      $this->app->httpResponse()->redirect('bootstrap.php?action=executeModerateComments');
    }

    $commentsToModerate = $managerC->getCommentsToModerate();

    $this->page->addVar('title', 'Commentaires à modérer');
    $this->page->addVar('comments', $commentsToModerate);
  }
}

?>
