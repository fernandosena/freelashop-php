<?php
ob_start();

require __DIR__ . "/vendor/autoload.php";

/**
 * BOOTSTRAP
 */

use CoffeeCode\Router\Router;
use Source\Core\Session;

$session = new Session();
$route = new Router(url(), ":");


/**
 * ***********************************************************************************
 */
/**
 * WEB
 */
$route->namespace("Source\App\Web");
$route->group(null);
$route->get("/", "Web:home");
$route->get("/sobre", "Web:about");
$route->get("/projetos", "Web:project");
$route->get("/freelancers", "Web:freelancer");
$route->get("/faq/freelancer", "Web:faq");
$route->get("/faq/contratante", "Web:faq");
$route->get("/termos-de-uso", "Web:terms");
$route->get("/politica-de-privacidade", "Web:privacy");
$route->get("/confirma", "Web:confirm");
$route->get("/obrigado/{email}", "Web:success");
$route->get("/dash", "Web:dash");

$route->get("/criar-projeto", "Project:action");


$route->get("/entrar", "User:login");
$route->get("/cadastrar", "User:register");
$route->get("/cadastrar/{base64_email}", "User:register");
$route->get("/recuperar", "User:forget");
$route->get("/recuperar/{code}", "User:reset");

/*
 * BLOG
 */
$route->group("/blog");
$route->get("/", "Blog:blog");
$route->get("/p/{page}", "Blog:blog");
$route->get("/{uri}", "Blog:post");
$route->get("/buscar/{search}/{page}", "Blog:search");
$route->get("/em/{category}", "Blog:category");
$route->get("/em/{category}/{page}", "Blog:category");

$route->post("/buscar", "Blog:search");

/*
 * PROJECT
 */
$route->group("/projetos");
$route->get("/", "Project:project");
$route->get("/p/{page}", "Project:project");
$route->get("/{uri}", "Project:single");
$route->get("/buscar/{category}/{subcategory}/{terms}/{type}/{page}", "Project:search");

$route->post("/buscar", "Project:search");

/*
 * FREELANCER
 */
$route->group("/freelancers");
$route->get("/", "Freelancer:freelancer");
$route->get("/perfil/{email}", "Freelancer:profile");
$route->get("/p/{page}", "Freelancer:freelancer");
$route->get("/buscar/{category}/{terms}/{page}", "Freelancer:search");

$route->post("/buscar", "Freelancer:search");

/*
 * POST
 */
$route->group(null);
$route->post("/newsletter", "Web:newsletter");
$route->post("/subcategoria", "Web:subcategory");
$route->post("/filter", "Web:filter");

$route->post("/recuperar/resetar", "User:reset");
$route->post("/recuperar", "User:forget");
$route->post("/entrar", "User:login");
$route->post("/cadastrar", "User:register");
$route->post("/recuperar", "User:forget");

$route->post("/criar-projeto", "Project:action");
/**
 * ***********************************************************************************
 */


/**
 * PAY
 */

$route->namespace("Source\App\Pay");
$route->group("/pay");
$route->post("/plan", "Pay:plan");
$route->post("/update", "Pay:update");
$route->post("/proposal", "Pay:proposal");
/**
 * ***********************************************************************************
 */


/**
 * APP
 */
$route->namespace("Source\App\App");
$route->group("/app");
$route->get("/perfil", "App:profile");
$route->get("/sair", "App:logout");

$route->get("/assinatura", "Plan:home");
$route->get("/plan/checkout/{plan}", "Plan:checkout");

$route->get("/projetos", "Project:home");

$route->get("/propostas/{uri}", "Proposal:home");
$route->get("/proposta/{id}", "Proposal:proposal");
$route->get("/proposta/checkout/{proposal}", "Proposal:checkout");

$route->get("/chat", "Chat:home");
$route->get("/chat/{group}", "Chat:room");

$route->post("/freelancer/contract/{project}/{proposal}", "Freelancer:contract");

$route->post("/support", "App:support");
$route->post("/perfil", "App:profile");
$route->post("/report/{project}", "Project:report");
$route->post("/action/{type}/{uri}", "Project:action");
$route->post("/proposal/{uri}", "Proposal:home");
$route->post("/notification/chat/count", "Notifications:chatCount");
$route->post("/chat/send/{group}", "Chat:send");

/**
 * ***********************************************************************************
 */

/**
 * ADMIN
 */
$route->namespace("Source\App\Admin");
$route->group("/admin");

//login
$route->get("/", "Login:root");
$route->get("/login", "Login:login");

//dash
$route->get("/dash", "Dash:dash");
$route->get("/dash/home", "Dash:home");
$route->get("/logoff", "Dash:logoff");

$route->post("/login", "Login:login");
$route->post("/dash/home", "Dash:home");

//control
$route->get("/control/home", "Control:home");
$route->get("/control/subscriptions", "Control:subscriptions");
$route->post("/control/subscriptions", "Control:subscriptions");
$route->get("/control/subscriptions/{search}/{page}", "Control:subscriptions");
$route->get("/control/subscription/{id}", "Control:subscription");
$route->post("/control/subscription/{id}", "Control:subscription");
$route->get("/control/plans", "Control:plans");
$route->get("/control/plans/{page}", "Control:plans");
$route->get("/control/plan", "Control:plan");
$route->post("/control/plan", "Control:plan");
$route->get("/control/plan/{plan_id}", "Control:plan");
$route->post("/control/plan/{plan_id}", "Control:plan");

//blog
$route->get("/blog/home", "Blog:home");
$route->post("/blog/home", "Blog:home");
$route->get("/blog/home/{search}/{page}", "Blog:home");
$route->get("/blog/post", "Blog:post");
$route->post("/blog/post", "Blog:post");
$route->get("/blog/post/{post_id}", "Blog:post");
$route->post("/blog/post/{post_id}", "Blog:post");
$route->get("/blog/categories", "Blog:categories");
$route->get("/blog/categories/{page}", "Blog:categories");
$route->get("/blog/category", "Blog:category");
$route->post("/blog/category", "Blog:category");
$route->get("/blog/category/{category_id}", "Blog:category");
$route->post("/blog/category/{category_id}", "Blog:category");

//project
$route->get("/project/home", "Project:home");
$route->post("/project/home", "Project:home");
$route->get("/project/home/{search}/{page}", "Project:home");

$route->get("/project/pending", "Project:pending");
$route->post("/project/pending", "Project:pending");
$route->get("/project/pending/{search}/{page}", "Project:pending");

$route->get("/project/concluded", "Project:concluded");
$route->post("/project/concluded", "Project:concluded");
$route->get("/project/concluded/{search}/{page}", "Project:concluded");

$route->get("/project/pending-pay", "Project:pendingPay");
$route->post("/project/pending-pay", "Project:pendingPay");
$route->get("/project/pending-pay/{search}/{page}", "Project:pendingPay");

$route->get("/project/post", "Project:post");
$route->post("/project/post", "Project:post");
$route->get("/project/post/{post_id}", "Project:post");
$route->post("/project/post/{post_id}", "Project:post");
$route->get("/project/categories", "Project:categories");
$route->get("/project/categories/{page}", "Project:categories");
$route->get("/project/category", "Project:category");
$route->post("/project/category", "Project:category");
$route->get("/project/category/{category_id}", "Project:category");
$route->post("/project/category/{category_id}", "Project:category");

//contract
$route->get("/contract/home", "Contract:home");
$route->post("/contract/home", "Contract:home");
$route->get("/contract/home/{search}/{page}", "Contract:home");
$route->get("/contract/post", "Contract:post");
$route->post("/contract/post", "Contract:post");
$route->get("/contract/post/{post_id}", "Contract:post");
$route->post("/contract/post/{post_id}", "Contract:post");
$route->get("/contract/categories", "Contract:categories");
$route->get("/contract/categories/{page}", "Contract:categories");
$route->get("/contract/category", "Contract:category");
$route->post("/contract/category", "Contract:category");
$route->get("/contract/category/{category_id}", "Contract:category");
$route->post("/contract/category/{category_id}", "Contract:category");

//faqs
$route->get("/faq/home", "Faq:home");
$route->get("/faq/home/{page}", "Faq:home");
$route->get("/faq/channel", "Faq:channel");
$route->post("/faq/channel", "Faq:channel");
$route->get("/faq/channel/{channel_id}", "Faq:channel");
$route->post("/faq/channel/{channel_id}", "Faq:channel");
$route->get("/faq/question/{channel_id}", "Faq:question");
$route->post("/faq/question/{channel_id}", "Faq:question");
$route->get("/faq/question/{channel_id}/{question_id}", "Faq:question");
$route->post("/faq/question/{channel_id}/{question_id}", "Faq:question");

//users
$route->get("/users/home", "Users:home");
$route->post("/users/home", "Users:home");
$route->get("/users/home/{search}/{page}", "Users:home");
$route->get("/users/user", "Users:user");
$route->post("/users/user", "Users:user");
$route->get("/users/user/{user_id}", "Users:user");
$route->post("/users/user/{user_id}", "Users:user");


/**
 * ***********************************************************************************
 */
/**
 * ERROR ROUTES
 */
$route->namespace("Source\App\Web");
$route->group("/ops");
$route->get("/{errcode}", "Web:error");

/**
 * ROUTE
 */
$route->dispatch();

/**
 * ERROR REDIRECT
 */
if ($route->error()) {
    $route->redirect("/ops/{$route->error()}");
}

ob_end_flush();