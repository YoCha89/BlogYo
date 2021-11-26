<?php
namespace App\Frontend\Modules\Blog;

use OCFram\BackController;
use OCFram\HTTPRequest;
use App\Backend\Entity\Comments;
use App\Backend\Entity\BlogPosts;
use App\Backend\Model\BlogPostManagerPDO;

class BlogController extends BackController
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
        $managerA = $this->managers->getManagerOf('Admin');

        $blogPost = $managerB->getUnique($request->getData('id'));

        $tmp = $managerA->getUnique($blogPost['admin_id']);
        $author = $tmp['pseudo'];

        $c = stristr($blogPost['content'], '.');
        $content = substr($c, 1);

        $leadParagraphe = stristr($blogPost['content'], '.', true).'.';

        $listComments = $managerC-> getComments($request->getData('id'));

        $comments=[];
        foreach ($listComments as $comment){
            if($comment['validated'] == true){
                array_push($comments, $comment);
            }
        }

        $commentsNumber = count($comments);

        $this->page->addVar('blogPost', $blogPost);
        $this->page->addVar('content', $content);     
        $this->page->addVar('leadParagraphe', $leadParagraphe);
        $this->page->addVar('author', $author);
        $this->page->addVar('comments', $comments);
        $this->page->addVar('commentsNumber', $commentsNumber);
    }

    public function executePostComment (HTTPRequest $request) {
        if ($request->postExists('content')) {
            if ($this->app->user()->isAuthenticated() == false){
                $author = $request->postData('author');
                $accountId = null;
            }else{
                $author = $this->app->user()->getAttribute('pseudo');
                
                $accountId = $this->app->user()->getAttribute('id');
            }

            $blogP = $request->getData('id');

            $comment = new Comments ([
                'accountId' => $accountId,
                'author' => $author,
                'blogPostId' => $blogP,
                'content' => $request->postData('content'),
            ]);  

            $managerC = $this->managers->getManagerOf('comments');

            if($comment->isValid()) {
                $managerC->save($comment);

                $this->app->user()->setFlashSuccess('Votre commentaire a été enregistré. Il sera validé ou rejeté aprés un court délai !');

                $this->app->httpResponse()->redirect('bootstrap.php?action=seeBlog&id='.$request->getData('id'));

            } else {

                $this->app->user()->setFlashError('Entrez au moins un caractère autre qu\'un espace pour valider chaque champ');
                $this->app->httpResponse()->redirect('bootstrap.php?action=executePostComment&id='.$request->getData('id'));
            }
            
        } else {
            $managerB = $this->managers->getManagerOf('BlogPost');

            $blogPost = $managerB->getUnique($request->getData('id'));

            $accountId = $this->app->user()->getAttribute('id');
            $pseudo = $this->app->user()->getAttribute('pseudo');

            $this->page->addVar('blogPost', $blogPost);
            $this->page->addVar('accountId', $accountId);
            $this->page->addVar('pseudo', $pseudo);
        }  
    }

    public function executeModifyComment (HTTPRequest $request) {   
        //modKey is a hidden field of the modify form to check if the user is submitting the form or is arriving on the view. Checking the actual field content won't wor for we'll put old values as default values
        if ($request->postExists('modKey')){
            $comment = new Comments ([
            'id' => $request->postData('idC'),                
            'accountId' => $this->app->user()->getAttribute('id'),
            'author' => $this->app->user()->getAttribute('pseudo'),
            'blogPostId' => $request->getData('idB'),
            'content' => $request->postData('content'),
            'validated' => null
            ]);

            $managerC = $this->managers->getManagerOf('comments');

            if($comment->isValid()) {
                $managerC->save($comment);

                $this->app->user()->setFlashSuccess('Votre commentaire a été enregistré. Il sera validé ou rejeté aprés un court délai !');

                $this->app->httpResponse()->redirect('bootstrap.php?action=seeBlog&id='.$request->getData('id'));

            } else {

                $this->app->user()->setFlashError('Entrez au moins un caractère autre qu\'un espace pour valider chaque champ');
                $this->app->httpResponse()->redirect('bootstrap.php?action=executePostComment&id='.$request->getData('id'));
            }
            
        } else {
            $managerC = $this->managers->getManagerOf('comments');
            $managerB = $this->managers->getManagerOf('BlogPost');
            $comment = $managerC->getUnique($request->getData('id'));
            $blogPost = $managerB->getUnique($comment['blog_post_id']);

            $c = stristr($blogPost['content'], '.');
            $content = substr($c, 1);
            $leadParagraphe = stristr($blogPost['content'], '.', true).'.';

            $this->page->addVar('title', 'Mettre à jour votre commentaire');
            $this->page->addVar('blogPost', $blogPost);
            $this->page->addVar('content', $content);     
            $this->page->addVar('leadParagraphe', $leadParagraphe);
            $this->page->addVar('comment', $comment);
            $this->page->addVar('blogPost', $blogPost);
        }       
    }

        public function executeDeleteComment (HTTPRequest $request)
    {
        $managerC = $this->managers->getManagerOf('comments');
        $managerC->delete($request->getData('id'));

        $this->app->httpResponse()->redirect('bootstrap.php?action=seeBlog&id='.$request->getData('id'));
    }

        public function executeSeeMyComments (HTTPRequest $request)
    {
        $this->page->addVar('title', 'Mes commentaires');
        $accId = $this->app->user()->getAttribute('id');
        $managerC = $this->managers->getManagerOf('comments');

        $myComments = $managerC->getCommentsList($accId);
        $myCommentsNumber = count($myComments);

// var_dump($myComments , $myCommentsNumber);die;

        $this->page->addVar('myComments', $myComments);
        $this->page->addVar('myCommentsNumber', $myCommentsNumber);
    }
}