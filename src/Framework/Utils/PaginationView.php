<?php

namespace LPF\Framework\Utils;

use LPF\Framework\Utils\Link;

/**
 * Class to generate pagination view
 */
class PaginationView
{
    protected $controller = null;
    protected $action = null;
    protected $data = [];
    protected $page = 0;
    protected $pages = 0;
    protected $route = '';

    /**
     * Construct Pagination View
     *
     * @param string $controller
     * @param string $action
     * @param array $data
     * @param int $page
     * @param int $pages
     */
    public function __construct(
        $route,
        $data,
        $page,
        $pages
    ) {
        $this->route = $route;
        $this->data = $data;
        $this->page = $page;
        $this->pages = $pages;
    }

    /**
     * Returns data with actual page index
     *
     * @param int $page
     * @return array
     */
    public function getMergedData($page)
    {
        return array_merge($this->data, ['page' => $page]);
    }

    /**
     * Link to page with data
     *
     * @param int $page
     * @return string
     */
    public function pageLink($page)
    {
        return Link::toRoute($this->route, $this->getMergedData($page));
    }

    /**
     * Links to pages
     *
     * @return string
     */
    public function links()
    {
        $linksTemplate = "";

        // generate 2 links before current page and 2 after
        for ($i = $this->page - 2; $i < $this->page + 3; $i++) {
            $linkToPage = $this->pageLink($i); // link to page

            $pageIndex = $i + 1; // pages start from 0 so lets add 1 for display

            // is it current page? if so then add disabled link which show
            // on which page user is now on
            if ($this->page == $i) {
                $linksTemplate .= "<a class='btn btn-light btn-sm disabled' href='$linkToPage' disabled>" . $pageIndex . "</a>";
            } else {
                // check if page exists
                if ($i >= 0 && $i < $this->pages) {
                    $linksTemplate .= "<a class='btn btn-light btn-sm' href='$linkToPage'>" . $pageIndex . "</a>";
                }

            }
        }

        return $linksTemplate;
    }

    /**
     * Get HTML string which you can pass to template
     *
     * @return string
     */
    public function getView()
    {
        // if there is no any pages, then do not display pagination view
        if($this->pages == 1) return "<div class='text-muted small'>There is only one page.</div>";

        $template = "<div class='row'><div class='col-sm-12'>"
        . "<div class='small text-muted mb-1'>There is "
        . $this->pages . " pages in total.</div>"
            . "<div class='btn-group'>";

        // previous page link
        if ($this->page > 0) {
            $template .= "<a class='btn btn-light btn-sm' href='" .
            $this->pageLink($this->page - 1) .
                "'>< Previous</a>";
        }

        // links in middle
        $template .= $this->links();

        // next page link
        if ($this->page < $this->pages - 1) {
            $template .= "<a class='btn btn-light btn-sm' href='"
            . $this->pageLink($this->page + 1) .
                "'>Next ></a>";
        }

        $template .= "</div></div></div>";

        return $template;
    }
}
