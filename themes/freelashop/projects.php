<?php $v->layout("_theme"); ?>
<section id="projetos">
    <div class="centro">
        <div class="filtro">
            <form>
                <div class="form-group">
                    <label>Categoria</label>
                    <select>
                        <option value="">Todas as categorias</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Habilidades</label>
                    <input type="text" placeholder="Habilidade(s) desejada(s)">
                </div>
                <div class="form-group">
                    <label>Data de publicação</label>
                    <input type="text" placeholder="Data de publicação">
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
                        <div class="dados-projeto">
                            <div class="titulo">
                                <h2><a href="">Titulo do projeto</a></h2>
                            </div>
                            <div class="info-projeto">
                                <div>
                                    <label>Publicado: <span>há 1 hora</span></label>
                                    <label>Propostas: <span>1</span></label>
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
                            <button class="link"><a href="">Ver projeto</a></button>
                        </div>
                        <div class="dados">
                            <label>Orçamento</label>
                            <span>R$ 2.000,00 - R$ 10.000,00</span>
                        </div>
                    </div>
                </div>
                <?php endfor; ?>
            </div>
        </div>
    </div>
</section>