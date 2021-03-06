<?php $title = "Edit '". $thread_title ."' Thread" ?>
<h1>Edit '<?= $thread_title; ?>' thread</h1>
<?php // Checks for validation errors in the inputs passed
if ($thread->hasError() || $comment->hasError()): ?>
    <div class="alert alert-block">
        <h4 class="alert-heading">Validation error!</h4>        
        <?php // ERRORS FOR TITLE LENGTH VALIDATION //
        if (!empty($thread->validation_errors['title']['length'])): ?>
            <div>
                <em>Title</em> must be between
                <?php eh($thread->validation['title']['length'][1]) ?> and
                <?php eh($thread->validation['title']['length'][2]) ?> characters in length.
            </div>
        <?php endif ?>

        <?php // ERRORS FOR BODY LENGTH VALIDATION //
        if (!empty($comment->validation_errors['body']['length'])): ?>
            <div>
                <em>Comment</em> must be between
                <?php eh($comment->validation['body']['length'][1]) ?> and
                <?php eh($comment->validation['body']['length'][2]) ?> characters in length.
            </div>
        <?php endif ?>
        
        <?php  // ERRORS FOR TOO LONG CHARACTERS WITH NO SPACES AND CAN'T FIT THE SCREEN ANYMORE //
        if (!empty($comment->validation_errors['body']['format'])): ?>
            <div>
                <em>Comment</em> must have spaces to fit the screen.
            </div>        
        <?php endif ?>
    </div>
<?php endif ?>

<form class="well" method="post" action="<?php eh(url('')) ?>">
    <label>Title</label>
    <input type="text" class="span2" name="title" value="<?= $thread->title; ?>">

    <label>Comment</label>
    <textarea name="body"><?php eh(Param::get('body')) ?></textarea>
    <br />

    <button type="submit" class="btn btn-primary">Save Changes</button><br/><br/>
    <a href="<?php eh(url('thread/index')) ?>">
        &larr; Back to All Threads
    </a>
</form>
