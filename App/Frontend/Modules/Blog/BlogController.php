<?php
namespace App\Frontend\Modules\BlogPost;

use OCFram\BackController;
use OCFram\HTTPRequest;
use Entity\Likes;
use Entity\Comments;

class BlogPostController extends BackController
{
    public function executeBlogList (HTTPRequest $request)
    {

        $this->page->addVar('title', 'Articles');

        $managerB = $this->managers->getManagerOf('BlogPost');

        $listBlogPost = $managerB->getList();

        $this->page->addVar('listBlogPost', $listBlogPost);
    }	

    public function executeSeeBlog (HTTPRequest $request)
    {
        $managerB = $this->managers->getManagerOf('BlogPost');
        $managerC = $this->managers->getManagerOf('Comments');

        $blogs = $managerB->getUnique($request->getdata('id'));

        $listComments = $managerC-> getComments($request->getdata('id'));

        $comments=[];
        foreach ($listComments as $comment){
            if($comment->getValidated() == true){
                array_push($comments, $comment);
            }
        }

        $commentsNumber = count($comments);

        $this->page->addVar('title', $BlogPost['title']); 
        $this->page->addVar('BlogPost', $BlogPost);       
        $this->page->addVar('Comments', $Comments);
        $this->page->addVar('commentsNumber', $commentsNumber);
    }

    public function executePostComment (HTTPRequest $request)
    {
        if ($request->postExists('content'))
        {
            $comment = new Comments ([
            'accountId' => $this->app->user()->getAttribute('id'),
            'author' => $this->app->user()->getAttribute('pseudo'),
            'blogPostId' => $request->getData('id'),
            'content' => $request->postData('content')
            'validated' => null;
            ]);

            $managerC = $this->managers->getManagerOf('comments');

            if($comment->isValid())
            {
                $managerC->addComment($comment);

                $this->app->user()->setFlash('Votre commentaire a été enregistré. Il sera validé ou rejeté aprés un court délai !');

                $this->app->httpResponse()->redirect('bootstrap.php?action=executeSeeBlog&id='.$request->getdata('id'));

            } else {

                $this->app->user()->setFlash('Entrez au moins un caractère autre q\'un espace pour valider chaque champ');
                $this->app->httpResponse()->redirect('bootstrap.php?action=executePostComment&id='.$request->getdata('id'));
            }
            
        } else {
            $managerB = $this->managers->getManagerOf('BlogPost');

            $blogPost = $managerB->getUnique($request->getdata('id'));
            $accountId = $this->app->user()->getAttribute('id');
            $pseudo = $this->app->user()->getAttribute('pseudo');

            $this->page->addVar('blogPost', $blogPost);
            $this->page->addVar('accountId', $accountId);
            $this->page->addVar('pseudo', $pseudo);
        }  
    }

    public function executeModifyComment (HTTPRequest $request)
    {   
        //modKey is a hidden field of the modify form to check if the user is submitting the form or is arriving on the view. Checking the actual field content won't wor for we'll put old values as default values
        if ($request->postExists('modKey')){
            $comment = new Comments ([
            'accountId' => $this->app->user()->getAttribute('id'),
            'author' => $this->app->user()->getAttribute('pseudo'),
            'blogPostId' => $request->getData('id'),
            'content' => $request->postData('content')
            'validated' => null;
            ]);

            $managerC = $this->managers->getManagerOf('comments');

            if($comment->isValid())
            {
                $managerC->addComment($comment);

                $this->app->user()->setFlash('Votre commentaire a été enregistré. Il sera validé ou rejeté aprés un court délai !');

                $this->app->httpResponse()->redirect('bootstrap.php?action=seeBlog&id='.$request->getdata('id'));

            } else {

                $this->app->user()->setFlash('Entrez au moins un caractère autre q\'un espace pour valider chaque champ');
                $this->app->httpResponse()->redirect('bootstrap.php?action=executePostComment&id='.$request->getdata('id'));
            }
            
        } else {
            $managerC = $this->managers->getManagerOf('Comment');
            $comment = $managerC->getUnique($request->getdata('id'));

            $this->page->addVar('comment', $comment);
        }       
    }

        public function executeDeleteComment (HTTPRequest $request)
    {
        $managerC = $this->managers->getManagerOf('Comment');
        $managerC->delete($request->getdata('id'));

        $this->app->httpResponse()->redirect('bootstrap.php?action=seeBlog&id='.$request->getdata('id'));
    }

        public function executeSeeMyComments (HTTPRequest $request)
    {
        $this->page->addVar('title', 'Mes commentaires');

        $managerC = $this->managers->getManagerOf('Comment');
        $myComments = $managerC->getAccountList($this->app->user()->getAttribute('id'));
        $myCommentsNumber = $managerC->countA($this->app->user()->getAttribute('id'));

        $this->page->addVar('myComments', $myComments);
        $this->page->addVar('myCommentsNumber', $myCommentsNumber);
    }
}