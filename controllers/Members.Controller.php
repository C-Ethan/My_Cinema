<?php
class MembersController {
    private $memberModel;
    private $allowedLimits = [10, 25, 50, 100];

    public function __construct() {
        $this->memberModel = new Member();
    }

    public function index() {
        $search = isset($_GET['search']) ? trim($_GET['search']) : '';
        $searchType = isset($_GET['search_type']) ? $_GET['search_type'] : 'all';
        $page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
        $limit = isset($_GET['limit']) && in_array(intval($_GET['limit']), $this->allowedLimits)
            ? intval($_GET['limit'])
            : 10;

        $members = $this->memberModel->searchMembers($search, $searchType, $limit, $page);
        $totalMembers = $this->memberModel->getTotalMembers($search, $searchType);
        $totalPages = ceil($totalMembers / $limit);

        extract([
            'members' => $members,
            'search' => $search,
            'searchType' => $searchType,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'limit' => $limit,
            'allowedLimits' => $this->allowedLimits
        ]);

        require_once ROOT . '/views/member.php';
    }

    // Ajoutez ces méthodes pour permettre l'accès aux données depuis index.php
    public function getMembers($search = '', $searchType = 'all', $limit = 20, $page = 1) {
        return $this->memberModel->searchMembers($search, $searchType, $limit, $page);
    }

    public function getTotalMembers($search = '', $searchType = 'all') {
        return $this->memberModel->getTotalMembers($search, $searchType);
    }
}