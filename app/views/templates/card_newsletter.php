<div class="card2_container bg-black">

    <div class="card2_body">

        <div class="newsletterCard_body">
            <?php if (empty($newsletter['sucesso']['email_newsletter'])): ?>
                <p>📭 Ops! Você ainda não está inscrito na nossa newsletter.</p>
                <p>Não perca as novidades e promoções exclusivas!</p>
                <p>🚗✨ Inscreva-se agora e fique por dentro de tudo. 😊</p>
            <?php else: ?>
                <div>
                    <p>
                        <span style="font-size: 1em;">Cadastrado desde:</span>
                        <?= date('d/m/Y', strtotime($newsletter['sucesso']['data_cadastro'])) ?>
                    </p>
                </div>
                <div>
                    <p>
                        Fique de olho na sua caixa de entrada para receber novidades, promoções exclusivas 🚗💨 e dicas incríveis para cuidar do seu veículo! 😉
                    </p>
                </div>
            <?php endif; ?>
        </div>

        <div class="newsletter">
            <?php if (empty($newsletter['sucesso']['email_newsletter'])): ?>
                <form id="formNewsletter" action="<?= BASE_URL_APP ?>index.php?url=home/cadastrarnewsletter" method="POST">
                    <button type="submit" class="btn_app">Inscrever</button>
                </form>
            <?php endif; ?>
        </div>

    </div>

</div>