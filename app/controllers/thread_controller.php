<?php
class ThreadController extends AppController
{
    const THREADS_PER_PAGE = 10;

    /**
     *VIEW ALL THREADS
     */        
    public function index()
    {
        check_user_logged_out();
        $cur_page = Param::get('pn');
        $num_rows = Thread::getNumRows();
        $pagination = pagination($num_rows, $cur_page, self::THREADS_PER_PAGE);
        // TODO: Get all threads
        $threads = Thread::getAll($pagination['limit']);
        $this->set(get_defined_vars());
    }

    /**
     *CREATE A NEW THREAD
     *@throws ValidationException
     */
    public function create()
    {
        check_user_logged_out();
        $thread = new Thread;
        $comment = new Comment;
        $title = Param::get('title');
        $body = Param::get('body');
        if(isset($title) || isset($body)) {
            try {
                $thread->title = Param::get('title');
                $thread->user_id = $_SESSION['user_id'];
                $comment->username = $_SESSION['uname'];
                $comment->body = Param::get('body');
                $new_thread_id = $thread->create($comment);
                redirect("comment", "view", array("thread_id" => $new_thread_id));
            } catch (ValidationException $e) {
                
            }                
        }
        $this->set(get_defined_vars());
    }

    /**
     *EDIT A THREAD
     *@throws ValidationException
     */
    public function edit()
    {            
        $thread_id = Param::get("thread_id");
        $title = Param::get('title');
        $body = Param::get('body');
        $thread = Thread::get($thread_id);
        $thread_title = $thread->title;
        $comment = new Comment;
        if(isset($title) || isset($body)){
            try {
                $thread->title = Param::get('title');
                $thread->user_id = $_SESSION['user_id'];
                $comment->username = $_SESSION['uname'];
                $comment->body = Param::get('body');
                $thread->update($comment);
                redirect("comment", "view", array("thread_id" => $thread_id));
            } catch (ValidationException $e) {

            }
        }
        $this->set(get_defined_vars());
    }
    
    /**
     *DELETE A THREAD
     */
    public function delete()
    {
        check_user_logged_out();
        $thread = Thread::get(Param::get('thread_id'));
        $thread_title = $thread->title;
        $thread->delete(); 
        redirect("thread", "index");
        $this->set(get_defined_vars());
    }
}
