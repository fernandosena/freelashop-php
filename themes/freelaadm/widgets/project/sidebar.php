<div class="dash_content_sidebar">
    <h3 class="icon-asterisk">dashboard/projeto</h3>
    <p class="dash_content_sidebar_desc">Aqui você gerencia todos os artigos e categorias do projeto...</p>

    <nav>
        <?php
        $nav = function ($icon, $href, $title) use ($app) {
            $active = ($app == $href ? "active" : null);
            $url = url("/admin/{$href}");
            return "<a class=\"icon-{$icon} radius {$active}\" href=\"{$url}\">{$title}</a>";
        };

        echo $nav("pencil-square-o", "project/pending", "Analise ({$balance->pending})");
        echo $nav("pencil-square-o", "project/pending-pay", "Pagamento pendente ({$balance->pending_pay})");
        echo $nav("pencil-square-o", "project/concluded", "Liberar valor ({$balance->concluded})");
        echo $nav("pencil-square-o", "project/home", "Todos os projeto ({$balance->full})");
        echo $nav("bookmark", "project/categories", "Categorias");
        ?>
        <?php if (!empty($post->cover)): ?>
            <img class="radius" style="width: 100%; margin-top: 30px" src="<?= image($post->cover, 680); ?>"/>
        <?php endif; ?>

        <?php if (!empty($category->cover)): ?>
            <img class="radius" style="width: 100%; margin-top: 30px" src="<?= image($category->cover, 680); ?>"/>
        <?php endif; ?>
    </nav>
</div>