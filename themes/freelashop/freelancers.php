<?php $v->layout("_theme"); ?>
<section id="freelancers">
    <div class="centro">
        <div class="filtro">
            <form>
                <div class="form-group">
                    <label>Atividade freelancer</label>
                    <select>
                        <option value="">Todas as categorias</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Habilidades</label>
                    <input type="text" placeholder="Habilidade(s) desejada(s)">
                </div>
                <div class="form-group">
                    <label>Preço por hora</label>
                    <div class="valores">
                        <input type="number" class="real" placeholder="Min" min="0">
                        <input type="number" class="real" placeholder="Max" max="200">
                    </div>
                </div>
                <div class="grupo-btn">
                    <button type="submit" class="no-link">filtrar</button>
                </div>
            </form>
        </div>
        <div class="projetos">
            <div class="pesquisa">
                <input type="search" placeholder="Buscar">
            </div>
            <div class="box-projetos">
                <?php for($i=1; $i<=8; $i++): ?>
                <div class="item">
                    <div class="esquerda">
                        <div class="dados-freelancer">
                            <div class="image">
                                <img src="<?= theme("/assets/img/item.png")?>" alt="Passo1" title="Passo1">
                            </div>
                            <div class="">
                                <div class="titulo">
                                    <a href=""><h2>Fulano de tal</h2></a>
                                    <div>
                                        <label>Categoria</label>
                                        <label>
                                            <img src="<?= theme("/assets/img/vip.png")?>" alt="Passo1" title="Passo1">
                                            <img src="<?= theme("/assets/img/estrelas.png")?>" alt="Passo1" title="Passo1">
                                            <span class="stars"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="info">
                            <p>
                                Lörem ipsum trelig pev demiaktiv. sasas as assPolynånyd ina orat. Semirad vavis i
                                näbygon. Kontralig dobelt. Ol antingen. Lörem ipsum trelig pev demiaktiv. sasas as
                                assPolynånyd ina orat. Semirad vavis i näbygon.emiaktiv. sasas as assPolynånyd ina
                                orat...
                            </p>
                        </div>
                    </div>
                    <div class="direita">
                        <div class="grupo-btn">
                            <button class="link"><a href="">contratar</a></button>
                        </div>
                    </div>
                </div>
                <?php endfor; ?>
            </div>
        </div>
    </div>
</section>