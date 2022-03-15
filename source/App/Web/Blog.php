<?php
/**
 * Created by PhpStorm.
 * User: Fernando Sena
 * Date: 21/01/2022
 * Time: 08:09
 */

namespace Source\App\Web;


use Source\Models\Category;
use Source\Models\Post;
use Source\Support\Pager;

class Blog extends Web
{
    /**
     * SITE BLOG
     * @param array|null $data
     */
    public function blog(?array $data): void
    {
        $schema = [
            "@context" => "https://schema.org",
            "@graph" => [
                "@type" => "WebSite",
                [
                    "@id" => url("/blog")."/#website",
                    "url" => url("/blog"),
                    "name" => "Blog da ".CONF_SITE_NAME,
                    "description" => "A Plataforma de Contratação de Freelancer da Próxima Geração",
                    "potentialAction" => [
                        [
                            "@type" => "SearchAction",
                            "target" => [
                                "@type" => "EntryPoint",
                                "urlTemplate" => url("/blog")."/?s=[search_term_string]"
                            ],
                            "query-input" => "required name=search_term_string"
                        ]
                    ],
                    "inLanguage" => "pt-BR"
                ],
                [
                    "@type" => "CollectionPage",
                    "@id" => url("/blog")."/#website",
                    "url" => url("/blog"),
                    "name" => "Blog da ".CONF_SITE_NAME." - A Plataforma de Contratação de Freelancer da Próxima Geração",
                    "isPartOf" => [
                        "@id" => url("/blog")."/#website"
                    ],
                    "description" => "A Plataforma de Contratação de Freelancer da Próxima Geração",
                    "breadcrumb" => [
                        "@id" => url("/blog")."/#breadcrumb"
                    ],
                    "inLanguage" => "pt-BR",
                    "potentialAction" => [
                        [
                            "@type" => "SearchAction",
                            "target" => [
                                url("/blog")
                            ]
                        ]
                    ]
                ],
                [
                    "@type" => "BreadcrumbList",
                    "@id" => url("/blog")."/#breadcrumb",
                    "itemListElement" => [
                        [
                            "@type" => "ListItem",
                            "position" => 1,
                            "name" => "Home",
                            "item" => url()
                        ]
                    ]
                ],
            ]
        ];


        $head = $this->seo->render(
            "Blog - " . CONF_SITE_NAME,
            "Confira em nosso blog dicas e sacadas de como controlar melhorar suas contas. Vamos tomar um café?",
            url("/blog"),
            theme("/assets/images/share.jpg"),
            true,
            $schema
        );

        $blog = (new Post())->findPost();
        $pager = new Pager(url("/blog/p/"));
        $pager->pager($blog->count(), 9, ($data['page'] ?? 1));

        echo $this->view->render("blog", [
            "head" => $head,
            "blog" => $blog->order("post_at DESC")->limit($pager->limit())->offset($pager->offset())->fetch(true),
            "paginator" => $pager->render()
        ]);
    }

    /**
     * SITE BLOG CATEGORY
     * @param array $data
     */
    public function category(array $data): void
    {
        $categoryUri = filter_var($data["category"], FILTER_SANITIZE_STRIPPED);
        $category = (new Category())->findByUri($categoryUri);

        if (!$category) {
            redirect("/blog");
        }

        $blogCategory = (new Post())->findPost("category = :c", "c={$category->id}");
        $page = (!empty($data['page']) && filter_var($data['page'], FILTER_VALIDATE_INT) >= 1 ? $data['page'] : 1);
        $pager = new Pager(url("/blog/em/{$category->uri}/"));
        $pager->pager($blogCategory->count(), 9, $page);

        $head = $this->seo->render(
            "Artigos em {$category->title} - " . CONF_SITE_NAME,
            $category->description,
            url("/blog/em/{$category->uri}/{$page}"),
            ($category->cover ? image($category->cover, 1200, 628) : theme("/assets/images/share.jpg"))
        );

        echo $this->view->render("blog", [
            "head" => $head,
            "title" => "Artigos em {$category->title}",
            "desc" => $category->description,
            "blog" => $blogCategory
                ->limit($pager->limit())
                ->offset($pager->offset())
                ->order("post_at DESC")
                ->fetch(true),
            "paginator" => $pager->render()
        ]);
    }

    /**
     * SITE BLOG SEARCH
     * @param array $data
     */
    public function search(array $data): void
    {
        if (!empty($data['s'])) {
            $search = str_search($data['s']);
            echo json_encode(["redirect" => url("/blog/buscar/{$search}/1")]);
            return;
        }

        $search = str_search($data['search']);
        $page = (filter_var($data['page'], FILTER_VALIDATE_INT) >= 1 ? $data['page'] : 1);

        if ($search == "all") {
            redirect("/blog");
        }

        $head = $this->seo->render(
            "Pesquisa por {$search} - " . CONF_SITE_NAME,
            "Confira os resultados de sua pesquisa para {$search}",
            url("/blog/buscar/{$search}/{$page}"),
            theme("/assets/images/share.jpg")
        );

        $blogSearch = (new Post())->findPost("MATCH(title, subtitle) AGAINST(:s)", "s={$search}");

        if (!$blogSearch->count()) {
            echo $this->view->render("blog", [
                "head" => $head,
                "title" => "PESQUISA POR:",
                "search" => $search
            ]);
            return;
        }

        $pager = new Pager(url("/blog/buscar/{$search}/"));
        $pager->pager($blogSearch->count(), 9, $page);

        echo $this->view->render("blog", [
            "head" => $head,
            "title" => "PESQUISA POR:",
            "search" => $search,
            "blog" => $blogSearch->limit($pager->limit())->offset($pager->offset())->fetch(true),
            "paginator" => $pager->render()
        ]);
    }

    /**
     * SITE BLOG POST
     * @param array $data
     */
    public function post(array $data): void
    {

        $post = (new Post())->findByUri($data['uri']);
        if (!$post) {
            redirect("/404");
        }

        if (!$this->user || $this->user->level < 5) {
            $post->views += 1;
            $post->save();
        }

        $schema = [
            "@context" => "https://schema.org",
            "@graph" => [
                "@type" => "WebSite",
                [
                    "@id" => url("/blog")."/#website",
                    "url" => url("/blog"),
                    "name" => "Blog da ".CONF_SITE_NAME,
                    "description" => "A Plataforma de Contratação de Freelancer da Próxima Geração",
                    "potentialAction" => [
                        [
                            "@type" => "SearchAction",
                            "target" => [
                                "@type" => "EntryPoint",
                                "urlTemplate" => url("/blog")."/?s=[search_term_string]"
                            ],
                            "query-input" => "required name=search_term_string"
                        ]
                    ],
                    "inLanguage" => "pt-BR"
                ],
                [
                    "@type" => "ImageObject",
                    "@id" => url("/blog/{$post->uri}")."/#primaryimage",
                    "inLanguage" => "pt-BR",
                    "url" => ($post->cover ? image($post->cover, 1200, 628) : theme("/assets/images/share.jpg")),
                    "contentUrl" => ($post->cover ? image($post->cover, 1200, 628) : theme("/assets/images/share.jpg")),
                    "width" => 1200,
                    "height" => 628
                ],
                [
                    "@type" => "WebPage",
                    "@id" => url("/blog/{$post->uri}")."/#webpage",
                    "url" => url("/blog/{$post->uri}"),
                    "name" => "O que é um Freelancer e Como Contratar Um - Blog ".CONF_SITE_NAME,
                    "isPartOf" => [
                        "@id" => url("/blog")."/#website"
                    ],
                    "primaryImageOfPage" => [
                        "@id" => url("/blog/{$post->uri}")."/#primaryimage"
                    ],
                    "datePublished" => date("Y-m-d\TH:i:s+00:00", strtotime($post->created_at)),
                    "dateModified" => date("Y-m-d\TH:i:s+00:00", strtotime($post->updated_at)),
                    "author" => [
                        "@id" => url("/blog/{$post->uri}")
                    ],
                    "description" => $post->subtitle,
                    "breadcrumb" => [
                        "@id" => url("/blog/{$post->uri}")."/#breadcrumb"
                    ],
                    "inLanguage" => "pt-BR",
                    "potentialAction" => [
                        [
                            "@type" => "ReadAction",
                            "target" => [
                                url("/blog/{$post->uri}")
                            ]
                        ]
                    ]
                ],
                [
                    "@type" => "BreadcrumbList",
                    "@id" => url("/blog/{$post->uri}")."/#breadcrumb",
                    "itemListElement" => [
                        [
                            "@type" => "ListItem",
                            "position" => 1,
                            "name" => "Home",
                            "item" => url()
                        ],
                        [
                            "@type" => "ListItem",
                            "position" => 2,
                            "name" => $post->title
                        ]
                    ]
                ],
                [
                    "@type" => "Person",
                    "@id" => url(),
                    "name" => "Fernando C. Sena",
                    "image" => [
                        "@type" => "ImageObject",
                        "@id" => url("/blog")."/#personlogo",
                        "inLanguage" => "pt-BR",
                        "url" => "https://pt.gravatar.com/userimage/187532843/a60a8448b10755b29b6465e84f189e54.jpeg",
                        "contentUrl" => "https://pt.gravatar.com/userimage/187532843/a60a8448b10755b29b6465e84f189e54.jpeg",
                        "caption" => "Fernando C. Sena"
                    ],
                    "description" => "Fernando C Sena é estudante de Ciência da computação na Universidade Anhambi Morumbi, e trabalha como Desenvolvedor na Softhubo. Já trabalhou com infraestrutura, desenvolvimento de sites e sistemas webs. É apaixonada por tecnologia e agora demonstra sua paixão criando sites para seus clientes e projetos proprios com muito carinho. Nas horas vagas, Fernando ama ficar com seus dois gatos, ver séries (as sitcoms são suas favoritas). Um fato curioso sobre o autor => seu primeiro bichinho de estimação foi um cachorro, chamado Rabito igual a novela Carrocel do SBT.",
                    "birthDate" => "1999-02-25",
                    "gender" => "masculino",
                    "knowsLanguage" => [
                        "Português brasileiro",
                        "Inglês"
                    ],
                    "jobTitle" => "Web Designer",
                    "worksFor" => "Softhuo",
                    "url" => url()
                ]
            ]
        ];

        $head = $this->seo->render(
            "{$post->title} - " . CONF_SITE_NAME,
            $post->subtitle,
            url("/blog/{$post->uri}"),
            ($post->cover ? image($post->cover, 1200, 628) : theme("/assets/images/share.jpg")),
            true,
            $schema
        );

        echo $this->view->render("blog-post", [
            "head" => $head,
            "post" => $post,
            "related" => (new Post())
                ->findPost("category = :c AND id != :i", "c={$post->category}&i={$post->id}")
                ->order("rand()")
                ->limit(3)
                ->fetch(true)
        ]);
    }
}