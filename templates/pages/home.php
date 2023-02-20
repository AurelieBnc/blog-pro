<!-- Header - set the background image for the header in the line below-->
<header class="py-5 bg-image-full" style="background-image: url('https://source.unsplash.com/wfh8dDlNFOk/1600x900')">
    <div class="text-center my-5">
        <img class="img-fluid rounded-circle mb-4" src="../public/images/avatar/myavatar2.png" alt="..." />
        <h1 class="text-white fs-3 fw-bolder">Beninca Aurélie</h1>
        <p class="text-white-50 mb-0">Phrase d'accroche</p>
    </div>
</header>
<!-- Content section-->
<section class="py-5">
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <h2>Full Width Backgrounds</h2>
                <p class="lead">A single, lightweight helper class allows you to add engaging, full width background
                    images to sections of your page.</p>
                <p class="mb-0">The universe is almost 14 billion years old, and, wow! Life had no problem starting
                    here on Earth! I think it would be inexcusably egocentric of us to suggest that we're alone in
                    the universe.</p>
            </div>
        </div>
    </div>
</section>
<!-- Image element - set the background image for the header in the line below-->
<div class="py-5 bg-image-full" style="background-image: url('https://source.unsplash.com/4ulffa6qoKA/1200x800')">
    <!-- Put anything you want here! The spacer below with inline CSS is just for demo purposes!-->
    <div style="height: 20rem"></div>
</div>
<!-- Content section-->
<section class="py-5">
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <h2 class="text-center text-primary-emphasis mb-5" title="Contactez moi !">Contactez moi !</h2>

                <form name="sentMessage" id="contactForm" novalidate>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingInput" placeholder="name" required
                            data-validation-required-message="Merci d'entrer votre nom."
                            title="Veuillez renseigner votre nom">
                        <p class="help-block text-danger"></p>
                        <label for="floatingInput">Nom</label>
                    </div>

                    <div class="form-floating mb-3 controls">
                        <input type="text" class="form-control" id="floatingInput" placeholder="firstname" required
                            data-validation-required-message="Please enter your name."
                            title="Veuillez renseigner votre prénom">
                        <label for="floatingInput">Prénom</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com"
                            title="Veuillez renseigner votre email">
                        <label for="floatingInput">Adresse email</label>
                    </div>
                    <!--INVALID INPUT
                <div class="form-floating mb-3">
                    <input type="email" class="form-control is-invalid" id="floatingInputInvalid"
                        placeholder="name@example.com" value="test@example.com">
                    <label for="floatingInputInvalid">Invalid input</label>
                </div> #} -->
                    <div class="form-group mb-3 controls">
                        <textarea rows="7" class="form-control" placeholder="Merci de laisser votre message"
                            id="floatingTextarea2" required data-validation-required-message="Please enter a message."
                            title="Veuillez entrer un message"></textarea>
                        <p class="help-block text-danger"></p>
                    </div>

                    <br>

                    <div id="success"></div>
                    <div class="form-group text-center d-flex justify-content-between">
                        <button type="submit" class="btn btn-outline-secondary" id="sendMessageButton"
                            title="Envoyer">Envoyer</button>
                        <button type="reset" class="btn btn-outline-secondary" id="resetMessageButton"
                            title="Réinitialiser">Réinitialiser</button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</section>