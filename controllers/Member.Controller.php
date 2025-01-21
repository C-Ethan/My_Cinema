<?php
class MemberController {
    private $memberModel;
    private $allowedLimits = [10, 25, 50, 100];

    public function __construct() {
        $this->memberModel = new Member();
    }

    public function index() {
        $lastnameSearch = isset($_GET['lastnameSearch']) ? trim($_GET['lastnameSearch']) : '';
        $firstnameSearch = isset($_GET['firstnameSearch']) ? trim($_GET['firstnameSearch']) : '';
        $page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
        $limit = isset($_GET['limit']) && in_array(intval($_GET['limit']), $this->allowedLimits)
            ? intval($_GET['limit'])
            : 10;

        $members = $this->memberModel->searchMembers($lastnameSearch, $firstnameSearch, $limit, $page);
        $totalMembers = $this->memberModel->getTotalMembers($lastnameSearch, $firstnameSearch);
        $totalPages = ceil($totalMembers / $limit);

        extract([
            'members' => $members,
            'lastnameSearch' => $lastnameSearch,
            'firstnameSearch' => $firstnameSearch,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'limit' => $limit,
            'allowedLimits' => $this->allowedLimits
        ]);

        require_once ROOT . '/views/member.view.php';
    }
}