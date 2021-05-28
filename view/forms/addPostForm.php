<?php $this->cssList[] = 'add_post.css' ?>
<?php $this->jsList[] = 'add_post.js' ?>


<form action="" method="post" enctype="multipart/form-data" >
    <div class="page" id="page1">
        <button class="next" id="nextButton" type="button"></button>
    </div>


    <div class="page" id="page2">

        <div class="form-suite">

            <div id="drop-zone">
                <img src="" alt="">
                <p>Drop file or click to upload</p>
<!--                <input type="hidden" name="MAX_FILE_SIZE" value="300000" />-->
                <input type="file" id="myfile" name="imageToUpload"
                       accept="image/*" hidden>
            </div>

            <div class="other-input">

                <div>
                    <label for="category">Catégorie</label>
                    <select name="category">
                        <option value="">--Choisir une catégorie--</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= $cat['id'] ?>"><?= $cat['category'] ?></option>
                        <?php endforeach; ?>
                    </select>

                </div>

                <div>
                    <label for="question">Votre question</label>
                    <textarea name="question" rows="1" cols="33"></textarea>

                </div>

                <div>

                    <label for="firstAnswer">Réponse 1</label>
                    <input type="text" name="firstAnswer" >

                </div>

                <div>
                    <label for="secondAnswer">Réponse 2</label>
                    <input type="text" name="secondAnswer" >

                </div>

                <div>

                    <label for="hashtags">Hastags</label>
                    <textarea name="hashtags" rows="1" cols="33"></textarea>
                </div>


                <button  type="submit" name="submit" value="submit" >Terminer</button>

            </div>


        </div>
    </div>
</form>