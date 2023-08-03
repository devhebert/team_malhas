<?php

class Paginate
{
    private int $pages;
    private int $current_page;

    public function __construct(private int $count_results, int $current_page = 1, private int $limit_per_page = 10)
    {
        $this->current_page = (is_numeric($current_page) and $current_page > 0) ? $current_page : 1;
        $this->calculatePagination();
    }

    private function calculatePagination(): void
    {
        $this->pages = $this->count_results > 0 ? ceil($this->count_results / $this->limit_per_page) : 1;
        $this->current_page = $this->current_page <= $this->pages ? $this->current_page : $this->pages;
    }

    public function getLimitOffset(): int
    {
        return ($this->current_page - 1) * $this->limit_per_page;
    }

    private function generatePaginationLinks(): array
    {
        if ($this->pages == 1) return [];

        $pages = [];
        for ($i = 1; $i <= $this->pages; $i++) {
            $pages[] = [
                'page' => $i,
                'current' => $i == $this->current_page
            ];
        }

        return $pages;
    }

    public function generatePaginationData($current_page = 1): string
    {
        $limit = 3;
        $pages = $this->generatePaginationLinks();

        if (count($pages) <= 1) return '';

        $links = '';

        $middle = ceil($limit / 2);

        $start = $middle > $current_page ? 0 : $current_page - $middle;

        $limit = $limit + $start;

        if ($limit > count($pages)) {
            $diff = $limit - count($pages);
            $start -= $diff;
        }

        $url = $this->validateRequest($_SERVER['REQUEST_URI']);

        if ($start > 0) {
            $links .= "<a class='dynamic-btn-page btn btn-sm btn-primary mr-2 btn-tm custom-font' href='" . $url . ".php?page=1'>1</a>";
        }

        $end = end($pages);

        foreach ($pages as $page) {
            if ($page['page'] <= $start) continue;

            if ($page['page'] > $limit) {
                $links .= "<a class='dynamic-btn-page btn btn-sm btn-primary ml-2 btn-tm custom-font' href='" . $url . ".php?page=" . $end['page'] . "'>" . $end['page'] . "</a>";
                break;
            }

            $active = $page['page'] == $current_page ? 'active' : '';

            $links .= '<a class="dynamic-btn-page btn btn-sm btn-primary btn-tm custom-font'. $active .'" href="' . $url . '.php?page=' . $page["page"] . '">' . $page['page'] . '</a>';
        }

        return $links;
    }

    public function validateRequest($uri): array|string
    {
        $filename = basename($uri);
        return pathinfo($filename, PATHINFO_FILENAME);
    }
}
