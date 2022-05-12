<footer>
   <div class="widget">
       <div class="centro">
           <div>
               <h2><?= CONF_SITE_NAME ?></h2>
               <p>A FreelaShop é a plataforma de trabalho freelance online cujo  foco diminuir as burocracias e valores
                   caros. Quando o assunto é inovar estamos sempre atentos.</p>
           </div>
           <div>
               <h3>Links rápidos</h3>
               <nav>
                   <ul>
                       <li><a href="<?= url()?>">Home</a></li>
                       <li><a href="<?= url("/sobre")?>">Sobre</a></li>
                       <li><a href="<?= url("/como-funciona/freelancer")?>">Tutorial freelancer</a></li>
                       <li><a href="<?= url("/como-funciona/contratante")?>">Tutorial contratante</a></li>
                       <li><a href="<?= url("/freelancers") ?>">Contratar freelancer</a></li>
                       <li><a href="">Cursos</a></li>
                       <li><a href="<?= url("/cadastre-se") ?>">Cadastrar</a></li>
                       <li><a href="<?= url("/entrar") ?>">Login</a></li>
                   </ul>
               </nav>
           </div>
           <div>
               <h3>Informações</h3>
               <nav>
                   <ul>
                       <li><a href="">A equipe</a></li>
                       <li><a href="">Perguntas Frequentes</a></li>
                       <li><a href="">Por que freelancer?</a></li>
                       <li><a href="">Contato</a></li>
                   </ul>
               </nav>
           </div>
           <div>
               <h3>Fale conosco</h3>
               <div class="endereco">
                   <p><i class="fa-solid fa-location-dot"></i></p>
                   <p>Magalhães Lemos, Nº 203,  05207-130 - São Paulo - SP</p>
               </div>
               <div class="email">
                   <p><i class="fa-solid fa-envelope"></i></p>
                   <p><a href="mailto:<?= CONF_SITE_EMAIL["SAC"] ?>"><?= CONF_SITE_EMAIL["SAC"] ?></a></p>
               </div>
           </div>
       </div>
   </div>
    <div class="footer">
        <p>Copyright 2021-2022 - <a href="<?= url("/") ?>"><?= CONF_SITE_DOMAIN ?></a></p>
    </div>
</footer>