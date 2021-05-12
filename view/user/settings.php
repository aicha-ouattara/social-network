<section>
    <?php if($user->getHis('picture')==0){
        echo "no picture";
    }
    else echo "picture"; ?>
    <?php if($user->getHis('background')==0){
        echo "no background";
    }
    else echo "background"; ?>
</section>