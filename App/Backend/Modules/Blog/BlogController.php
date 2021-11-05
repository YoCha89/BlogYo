<?php
namespace App\Backend\Modules\Blog;

use OCFram\BackController;
use OCFram\HTTPRequest;
use App\Backend\Entity\BlogPosts;
use App\Backend\Entity\Comments;

class BlogController extends BackController{

  public function executeBackPostBlog(HTTPRequest $request){
    if ($request->postExists('content')){
        $slug = $this->app->user()->getAttribute('pseudo') .'-'. $request->getData('title');

        $blogPost = new Blogposts ([
        'adminId' => $this->app->user()->getAttribute('id'),
        'title' => $request->postData('title'),
        'content' => $request->postData('content'),     
        'media' => $request->getData('media'),
        'slug' => $slug
        ]);

        $managerB = $this->managers->getManagerOf('blogPost');

        if($blogPost->isValid())
        {
            $managerB->save($blogPost);

            $this->app->user()->setFlash('Votre article est publié !');

            $this->app->httpResponse()->redirect('bootstrap.php?action=seeBlog&id='.$request->getdata('id'));

        } else {

            $this->app->user()->setFlash('Entrez au moins un caractère autre q\'un espace pour valider chaque champ');
            $this->app->httpResponse()->redirect('bootstrap.php?action=blogList');
        }
        
    } else {

        $this->page->addVar('title', 'Nouvelle publication');
    }  
  }

  public function executeBackModifyBlog(HTTPRequest $request){
    $managerB = $this->managers->getManagerOf('blogPost');
    //modKey is a hidden field of the modify form to check if the user is submitting the form or is arriving on the view. Checking the actual field content won't wor for we'll put old values as default values
    if ($request->postExists('modKey')){
        
        $blogPost = new Blogposts ([
        'adminId' => $this->app->user()->getAttribute('id'),
        'title' => $request->postData('title'),
        'content' => $request->postData('content'),     
        'media' => $request->getData('media'),
        'slug' => $slug
        ]);

        if($blogPost->isValid())
        {
            $managerB->save($blogPost);

            $this->app->user()->setFlash('Votre article a été mis à jour !');
            $this->app->httpResponse()->redirect('bootstrap.php?action=blogList');

        } else {

            $this->app->user()->setFlash('Entrez au moins un caractère autre q\'un espace pour valider chaque champ');
            $this->app->httpResponse()->redirect('bootstrap.php?app=backend&action=modifyBlog&id='.$request->getdata('id'));
        }
        
    } else {
        
        $blogPost = $managerB->getUnique($request->getdata('id'));

        $this->page->addVar('title', 'Editez votre article');
        $this->page->addVar('Blogpost', $blogPost);
    }       

  }

  public function executeBackDeleteBlog(HTTPRequest $request){
    $managerB = $this->managers->getManagerOf('blogPost');
    $managerB->delete($request->getdata('id'));

    $this->app->httpResponse()->redirect('bootstrap.php?action=blogList');
  }

  public function executeBackModerateComment(HTTPRequest $request){
    $managerC = $this->managers->getManagerOf('comments');

    if ($request->postExists('proof')){
        $check = [];
        $verdicts = [];
        foreach($_POST as $key=>$p){
            $tmp = preg_split('/_/', $key);

            if(!in_array($tmp[1], $check)){
                array_push ($check, $tmp[1]);
                $$tmp[1] = [];
            }

            switch ($tmp[0]) {
                case 'account':
                    $$tmp[1][0] = $p;
                    break;
                case 'blogPost':
                    $$tmp[1][1] = $p;
                    break;
                case 'com':
                    $$tmp[1][2] = $p;
                    break;
                case 'verdict':
                    $$tmp[1][3] = $p;
                    break;
            }

            if(isset($$tmp[1][0]) && isset($$tmp[1][1]) && isset($$tmp[1][2]) && isset($$tmp[1][3])){
                array_push($verdicts, $$tmp[1]);
            }
        }    

    foreach($verdicts as $v){
        $comment = $managerC->getUnique($v[2]);

        if($comment != null){
             if($v[3] == true){
                $managerC->moderate(1, $v[2]);
                $done = 'done';
                unset($v);
            }elseif($v[3] == false){
                $managerC->moderate(0, $v[2]);
                $done = 'done';
                unset($v);
            }else{
                unset($v);
            }   
        }
    }

        if(isset($done)){
            $this->app->user()->setFlash('Choix appliqués !');
        }
        $this->app->httpResponse()->redirect('bootstrap.php?app=Backend&action=backModerateComment');
    }

    $commentsToModerate = $managerC->getCommentsToModerate();

    $this->page->addVar('title', 'Commentaires à modérer');
    $this->page->addVar('comments', $commentsToModerate);
  }
}

?>
