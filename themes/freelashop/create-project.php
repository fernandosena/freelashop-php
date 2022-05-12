<?php $v->layout("_theme"); ?>
<section id="criar-projeto">
    <div class="centro">
        <div id="stepper1" class="bs-stepper">
            <div class="bs-stepper-header" role="tablist">
                <div class="bs-stepper-line"></div>
                <div class="step" data-target="#test-l-1">
                    <button type="button" class="step-trigger" role="tab" id="stepper1trigger1" aria-controls="test-l-1">
                        <span class="bs-stepper-circle">1</span>
                        <span class="bs-stepper-label">O que você precisa?</span>
                    </button>
                </div>
                <div class="bs-stepper-line"></div>
                <div class="step" data-target="#test-l-2">
                    <button type="button" class="step-trigger" role="tab" id="stepper1trigger2" aria-controls="test-l-2">
                        <span class="bs-stepper-circle">2</span>
                        <span class="bs-stepper-label">Orçamento</span>
                    </button>
                </div>
                <div class="bs-stepper-line"></div>
            </div>
            <div class="bs-stepper-content">
                <form onsubmit="return false">
                    <div id="test-l-1" role="tabpanel" class="bs-stepper-pane" aria-labelledby="stepper1trigger1">
                        <div class="card">
                            <div class="header">
                                <label>O que você está procurando?</label>
                            </div>
                            <div class="body">
                                <div class="form-group">
                                    <label for="Categoria *">Titulo*</label>
                                    <input type="text" name="title" class="form-control" id="Categoria *" placeholder="Titulo do projeto">
                                </div>
                                <div class="form-group form-group-flex">
                                    <div>
                                        <label for="category">Categoria *</label>
                                        <select name="category" class="form-control" id="category">
                                            <option value="">Selecione uma categoria</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label for="subcategory">Subategoria *</label>
                                        <select name="subcategory" class="form-control" id="subcategory">
                                            <option value="">Selecione uma subcategoria</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card conta">
                            <div class="header">
                                <label>Informações da conta</label>
                            </div>
                            <div class="body">
                                <div class="form-group form-group-flex">
                                    <div class="">
                                        <label for="first_name">Primeiro nome*</label>
                                        <input type="text" name="first_name" class="form-control" id="first_name" placeholder="Seu primeiro nome">
                                    </div>
                                    <div class="">
                                        <label for="last_name">Último nome*</label>
                                        <input type="text" name="last_name" class="form-control" id="last_name" placeholder="Seu ultimo nome">
                                    </div>
                                </div>
                                <div class="form-group form-group-flex">
                                    <div class="">
                                        <label for="first_name">E-mail*</label>
                                        <input type="email" name="email" class="form-control" id="email" placeholder="Seu e-mail">
                                    </div>
                                    <div class="">
                                        <label for="celular">Número de Celular*</label>
                                        <input type="text" name="celular" class="form-control" id="celular" placeholder="Número de celular">
                                    </div>
                                </div>
                                <div class="form-group form-group-flex">
                                    <div class="">
                                        <label for="senha">Senha*</label>
                                        <input type="password" name="email" class="form-control" id="senha" placeholder="Senha">
                                    </div>
                                    <div class="">
                                        <label for="repita_senha">Repita a senha*</label>
                                        <input type="text" name="repita_senha" class="form-control" id="repita_senha" placeholder="Repita a senha">
                                    </div>
                                </div>
                                <div class="grupo-btn">
                                    <button onclick="stepper1.next()" class="no-link"><a>Próximo</a></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="test-l-2" role="tabpanel" class="bs-stepper-pane" aria-labelledby="stepper1trigger2">
                        <div class="card conta">
                            <div class="header">
                                <label>Realização</label>
                            </div>
                            <div class="body">
                                <div class="form-group form-group-flex">
                                    <div class="">
                                        <label for="first_name">Orçamento*</label>
                                        <input type="text" name="first_name" class="form-control" id="first_name" placeholder="Selecione um orçamento">
                                    </div>
                                    <div class="">
                                        <label for="last_name">Habilidades (opcional, máx 10)</label>
                                        <input type="text" name="last_name" class="form-control" id="last_name" placeholder="Selecione um local de trabalho">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="first_name">Descrição*</label>
                                    <textarea name="email" class="form-control"placeholder="Descreva seu projeto da forma mais detalhada e clara possível. Dessa forma, você obterá mais respostas dos freelancers certos."></textarea>
                                </div>
                                <div class="grupo-btn">
                                    <button onclick="stepper1.previous()" class="no-link"><a>Voltar</a></button>
                                    <button class="no-link"><a>Publicar</a></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
