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
        // line 151
        echo "                    </body>
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
        // line 72
        echo "            ";
        $this->displayBlock('search_advance', $context, $blocks);
        // line 126
        echo "                        ";
        $this->displayBlock('jumplink', $context, $blocks);
        // line 144
        echo "                        ";
        $this->displayBlock('footer', $context, $blocks);
        // line 149
        echo "                        </table>
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
        echo "
            ";
    }

    // line 72
    public function block_search_advance($context, array $blocks = array())
    {
        // line 73
        echo "                        <tr>
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
        // line 90
        $this->displayBlock('danhmuc', $context, $blocks);
        // line 106
        echo "                                            <tr>
                                                <td>Thể loại</td>
                                                <td>
                                                    <select name=\"advanced_type\" id=\"advanced_type\" style=\"width: 90%; border: 2px solid #F79646;\">
                                                        <option>Tất cả</option>
                                                        <option>Webgame</option>
                                                    </select>
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

    // line 90
    public function block_danhmuc($context, array $blocks = array())
    {
        // line 91
        echo "

                                        <tr>
                                            <td>Danh mục</td>
                                            <td>
                                                <select name=\"advanced_cate\" id=\"advanced_cate\" style=\"width: 90%; border: 2px solid #F79646;\">
                                                   ";
        // line 97
        if (isset($context["danhmucs"])) { $_danhmucs_ = $context["danhmucs"]; } else { $_danhmucs_ = null; }
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($_danhmucs_);
        foreach ($context['_seq'] as $context["key"] => $context["value"]) {
            // line 98
            echo "
                                                        <option value=\"";
            // line 99
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
        // line 101
        echo "                                                    </select>
                                                </td>
                                            </tr>

                                                                ";
    }

    // line 126
    public function block_jumplink($context, array $blocks = array())
    {
        // line 127
        echo "                            <tr>
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

    // line 144
    public function block_footer($context, array $blocks = array())
    {
        // line 145
        echo "                            <tr bgcolor=\"#D9D9D9\">
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
        return array (  285 => 145,  282 => 144,  262 => 127,  259 => 126,  251 => 101,  239 => 99,  236 => 98,  231 => 97,  223 => 91,  220 => 90,  197 => 106,  195 => 90,  176 => 73,  173 => 72,  168 => 70,  165 => 69,  147 => 51,  144 => 50,  123 => 31,  120 => 30,  106 => 19,  103 => 18,  98 => 149,  95 => 144,  92 => 126,  89 => 72,  87 => 69,  82 => 66,  80 => 50,  77 => 49,  74 => 30,  72 => 18,  69 => 17,  66 => 16,  59 => 12,  49 => 4,  46 => 3,  41 => 151,  39 => 16,  35 => 14,  33 => 3,  29 => 1,);
    }
}
