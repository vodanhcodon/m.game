<?php

/* gameapp-main.twig */
class __TwigTemplate_0a5a1f794b251b6931b829bb20a7dcd7 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'head' => array($this, 'block_head'),
            'body' => array($this, 'block_body'),
            'banner' => array($this, 'block_banner'),
            'navigation' => array($this, 'block_navigation'),
            'search' => array($this, 'block_search'),
            'content' => array($this, 'block_content'),
            'search_advance' => array($this, 'block_search_advance'),
            'danhmuc' => array($this, 'block_danhmuc'),
            'jumplink' => array($this, 'block_jumplink'),
            'footer' => array($this, 'block_footer'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"vn\">
    <head>
        ";
        // line 3
        $this->displayBlock('head', $context, $blocks);
        // line 14
        echo "        </head>
        <body>
            ";
        // line 16
        $this->displayBlock('body', $context, $blocks);
        // line 178
        echo "                                </body>
                            </html>";
    }

    // line 3
    public function block_head($context, array $blocks = array())
    {
        // line 4
        echo "            <meta http-equiv=\"content-type\" content=\"application/xhtml+xml; charset=utf-8\"/>
            <meta http-equiv=\"Content-Style-Type\" content=\"text/css\"/>
            <meta name=\"Generator\" content=\"JohnCMS, http://johncms.com\"/>
            <meta name=\"keywords\" content=\"Game Online Hot\"/>
            <meta name=\"description\" content=\"Game online vteen.vn\"/>
            <link rel=\"stylesheet\" href=\"http://localhost/Gom-wapsite/theme/default/style.css\" type=\"text/css\"/>
            <link rel=\"shortcut icon\" href=\"http://localhost/Gom-wapsite/favicon.ico\"/>
            <link rel=\"alternate\" type=\"application/rss+xml\" title=\"RSS | Trang web Tin tức\" href=\"http://localhost/Gom-wapsite/rss/rss.php\"/>
            <title>";
        // line 12
        if (isset($context["title"])) { $_title_ = $context["title"]; } else { $_title_ = null; }
        echo twig_escape_filter($this->env, (($_title_) ? ($_title_) : ("Copyright  2012 vteen.vn")), "html", null, true);
        echo "</title>
        ";
    }

    // line 16
    public function block_body($context, array $blocks = array())
    {
        // line 17
        echo "                <table width=\"100%\" cellspacing=\"0\" border=\"0\" id=\"table1\">
            ";
        // line 18
        $this->displayBlock('banner', $context, $blocks);
        // line 30
        echo "            ";
        $this->displayBlock('navigation', $context, $blocks);
        // line 49
        echo "
            ";
        // line 50
        $this->displayBlock('search', $context, $blocks);
        // line 66
        echo "


            ";
        // line 69
        $this->displayBlock('content', $context, $blocks);
        // line 96
        echo "                            <tr><td colspan=\"2\">";
        if (isset($context["links"])) { $_links_ = $context["links"]; } else { $_links_ = null; }
        echo $this->getAttribute($_links_, "all");
        echo "</td></tr>
            ";
        // line 97
        $this->displayBlock('search_advance', $context, $blocks);
        // line 153
        echo "                        ";
        $this->displayBlock('jumplink', $context, $blocks);
        // line 171
        echo "                        ";
        $this->displayBlock('footer', $context, $blocks);
        // line 176
        echo "                                    </table>
";
    }

    // line 18
    public function block_banner($context, array $blocks = array())
    {
        // line 19
        echo "                        <tr class=\"header\">
                            <td colspan=\"2\">
                                <a href=\"http://localhost/Gom-wapsite\">
                                    <img border=\"0\" style=\"margin-top: 8px; border: none;\" alt=\"logo\" src=\"http://localhost/Gom-wapsite/theme/default/images/logo.png\"/>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td colspan=\"2\"></td>
                        </tr>
            ";
    }

    // line 30
    public function block_navigation($context, array $blocks = array())
    {
        // line 31
        echo "                        <tr>
                            <td colspan=\"2\" style=\"border-top: 1px solid #ffffff; padding: 0;\">
                                <div class=\"wrap\">
                                    <table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\">
                                        <tr>
                                            <td class=\"tab-selected\"><a href=\"#\">Thể loại 1</a></td>
                                            <td class=\"tab\"><a href=\"#\">Thể loại 2</a></td>
                                            <td class=\"tab\"><a href=\"#\">Top tải</a></td>
                                            <td class=\"tab\"><a href=\"#\">Sự kiện hot</a></td>
                                        </tr>
                                    </table>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan=\"2\"></td>
                        </tr>
            ";
    }

    // line 50
    public function block_search($context, array $blocks = array())
    {
        // line 51
        echo "                        <tr>
                            <td colspan=\"2\">
                                <form method=\"get\" action=\"http://localhost/Gom-wapsite/gamestore/index.php?src=&amp;act=search\">
                                    <table width=\"100%\">
                                        <tr>
                                            <td width=\"20%\">Tên game</td>
                                            <td width=\"60%\"><input type=\"hidden\" id=\"act\" name=\"act\" value=\"search\"/>
                                                <input type=\"text\" name=\"app_game_name\" id=\"app_game_name\" value=\"\" style=\"width: 90%; border: 2px solid #F79646;\"/></td>
                                            <td width=\"20%\"><input type=\"submit\" name=\"btn_search\" id=\"btn_search\" value=\"Tìm kiếm\" class=\"button\"/></td>
                                        </tr>
                                    </table>
                                </form>
                            </td>
                        </tr>
            ";
    }

    // line 69
    public function block_content($context, array $blocks = array())
    {
        // line 70
        echo "                        ";
        if (isset($context["page_data"])) { $_page_data_ = $context["page_data"]; } else { $_page_data_ = null; }
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($_page_data_);
        foreach ($context['_seq'] as $context["key"] => $context["value"]) {
            // line 71
            echo "                        <tr>
                            <td width=\"30%\">
                                <a href=\"http://localhost/Gom-wapsite/\">
                                    <img src=\"http://localhost/Gom-wapsite/images/Yahoo smile/Koala_1364060015.jpg\"/>
                                </a>
                            </td>
                            <td width=\"70%\" valign=\"top\">";
            // line 77
            if (isset($context["value"])) { $_value_ = $context["value"]; } else { $_value_ = null; }
            echo twig_escape_filter($this->env, $this->getAttribute($_value_, "name"), "html", null, true);
            echo "<br/>
                                ";
            // line 78
            if (isset($context["value"])) { $_value_ = $context["value"]; } else { $_value_ = null; }
            if (($this->getAttribute($_value_, "price") && ($this->getAttribute($_value_, "price") != 0))) {
                // line 79
                echo "                                    Giá: ";
                if (isset($context["value"])) { $_value_ = $context["value"]; } else { $_value_ = null; }
                echo twig_escape_filter($this->env, (($this->getAttribute($_value_, "price", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute($_value_, "price"), "0")) : ("0")), "html", null, true);
                echo " đồng<br/>
                                ";
            } else {
                // line 81
                echo "                                    ";
                if (isset($context["value"])) { $_value_ = $context["value"]; } else { $_value_ = null; }
                if ($this->getAttribute($_value_, "download_link")) {
                    // line 82
                    echo "                                    <a href=\"";
                    if (isset($context["value"])) { $_value_ = $context["value"]; } else { $_value_ = null; }
                    echo twig_escape_filter($this->env, $this->getAttribute($_value_, "download_link"), "html", null, true);
                    echo "\" title=\"Tải miễn phí\">Tải miễn phí</a><br/>
                                    ";
                } else {
                    // line 84
                    echo "                                    <a href=\"#\" title=\"Không hỗ trợ\">Không hỗ trợ</a><br/>
                                    ";
                }
                // line 86
                echo "                                ";
            }
            // line 87
            echo "                                ";
            if (isset($context["value"])) { $_value_ = $context["value"]; } else { $_value_ = null; }
            echo twig_escape_filter($this->env, $this->getAttribute($_value_, "short_decription"), "html", null, true);
            echo "<br/>
                                ";
            // line 88
            if (isset($context["value"])) { $_value_ = $context["value"]; } else { $_value_ = null; }
            echo twig_escape_filter($this->env, $this->getAttribute($_value_, "decription"), "html", null, true);
            echo "<br/>
                                    <div class=\"chitiet\">
                                        <a href=\"http://localhost/Gom-wapsite/\">Chi tiết</a>
                                    </div>
                                </td>
                            </tr>
                        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['key'], $context['value'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 95
        echo "            ";
    }

    // line 97
    public function block_search_advance($context, array $blocks = array())
    {
        // line 98
        echo "                                <tr>
                                    <td colspan=\"2\">
                                        <form method=\"get\" action=\"http://localhost/Gom-wapsite/gamestore/index.php?src=&amp;act=advanced\">
                                            <table width=\"100%\">
                                                <tr>
                                                    <td colspan=\"2\">
                                                        <span style=\"font-size: medium; color:red; font-weight: bold;\">
                                                            Tìm kiếm
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Tên game</td>
                                                    <td>
                                                        <input type=\"hidden\" name=\"act\" id=\"act\" value=\"advanced\"/>
                                                        <input type=\"text\" name=\"advanced_name\" id=\"advanced_name\" value=\"\" style=\"width: 88%; border: 2px solid #F79646;\"/></td>
                                                </tr>
                                                                ";
        // line 115
        $this->displayBlock('danhmuc', $context, $blocks);
        // line 131
        echo "                                                    <tr>
                                                        <td>Thể loại</td>
                                                        <td>
                                                            <select name=\"advanced_type\" id=\"advanced_type\" style=\"width: 90%; border: 2px solid #F79646;\">
                                                                  ";
        // line 135
        if (isset($context["the_loai"])) { $_the_loai_ = $context["the_loai"]; } else { $_the_loai_ = null; }
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($_the_loai_);
        foreach ($context['_seq'] as $context["key"] => $context["value"]) {
            // line 136
            echo "
                                                                    <option value=\"";
            // line 137
            if (isset($context["key"])) { $_key_ = $context["key"]; } else { $_key_ = null; }
            echo twig_escape_filter($this->env, $_key_, "html", null, true);
            echo "\">";
            if (isset($context["value"])) { $_value_ = $context["value"]; } else { $_value_ = null; }
            echo twig_escape_filter($this->env, $_value_, "html", null, true);
            echo "</option>
                                                                  ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['key'], $context['value'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 139
        echo "                                                                </select>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                            <td>
                                                                <input type=\"submit\" value=\"Tìm kiếm\" id=\"search\" name=\"search\" class=\"button\"/>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </form>
                                            </td>
                                        </tr>
                 ";
    }

    // line 115
    public function block_danhmuc($context, array $blocks = array())
    {
        // line 116
        echo "

                                                <tr>
                                                    <td>Danh mục</td>
                                                    <td>
                                                        <select name=\"advanced_cate\" id=\"advanced_cate\" style=\"width: 90%; border: 2px solid #F79646;\">
                                                   ";
        // line 122
        if (isset($context["danh_muc"])) { $_danh_muc_ = $context["danh_muc"]; } else { $_danh_muc_ = null; }
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($_danh_muc_);
        foreach ($context['_seq'] as $context["key"] => $context["value"]) {
            // line 123
            echo "
                                                                <option value=\"";
            // line 124
            if (isset($context["key"])) { $_key_ = $context["key"]; } else { $_key_ = null; }
            echo twig_escape_filter($this->env, $_key_, "html", null, true);
            echo "\">";
            if (isset($context["value"])) { $_value_ = $context["value"]; } else { $_value_ = null; }
            echo twig_escape_filter($this->env, $_value_, "html", null, true);
            echo "</option>
                                                  ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['key'], $context['value'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 126
        echo "                                                            </select>
                                                        </td>
                                                    </tr>

                                                                ";
    }

    // line 153
    public function block_jumplink($context, array $blocks = array())
    {
        // line 154
        echo "                                        <tr>
                                            <td colspan=\"2\"><hr/></td>
                                        </tr>
                                        <tr>
                                            <td colspan=\"2\"><table width=\"100%\">
                                                    <tr>
                                                        <td align=\"center\"><a href=\"#\" style=\"\">Top hot</a></td>
                                                        <td align=\"center\"><a href=\"#\">Top tải</a></td>
                                                        <td align=\"center\"><a href=\"#\">Sự kiện hot</a></td>
                                                        <td align=\"center\"><a href=\"#\">Diễn đàn</a></td>
                                                    </tr>
                                                </table></td>
                                        </tr>
                                        <tr>
                                            <td colspan=\"2\"><hr/></td>
                                        </tr>
                        ";
    }

    // line 171
    public function block_footer($context, array $blocks = array())
    {
        // line 172
        echo "                                        <tr bgcolor=\"#D9D9D9\">
                                            <td colspan=\"2\" style=\"font-size: small; text-align: center\"><span style=\"color:red; font-weight: bold;\">&copy; Copyright 2013 Vteen.vn</span></td>
                                        </tr>
                        ";
    }

    public function getTemplateName()
    {
        return "gameapp-main.twig";
    }

    public function getDebugInfo()
    {
        return array (  376 => 172,  373 => 171,  353 => 154,  350 => 153,  342 => 126,  330 => 124,  327 => 123,  322 => 122,  314 => 116,  311 => 115,  294 => 139,  282 => 137,  279 => 136,  274 => 135,  268 => 131,  266 => 115,  247 => 98,  244 => 97,  240 => 95,  226 => 88,  220 => 87,  217 => 86,  213 => 84,  206 => 82,  202 => 81,  195 => 79,  192 => 78,  187 => 77,  179 => 71,  173 => 70,  170 => 69,  152 => 51,  149 => 50,  128 => 31,  125 => 30,  111 => 19,  108 => 18,  103 => 176,  100 => 171,  97 => 153,  95 => 97,  89 => 96,  87 => 69,  82 => 66,  80 => 50,  77 => 49,  74 => 30,  72 => 18,  69 => 17,  66 => 16,  59 => 12,  49 => 4,  46 => 3,  41 => 178,  39 => 16,  35 => 14,  33 => 3,  29 => 1,);
    }
}
