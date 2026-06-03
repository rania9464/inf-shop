<?php
require_once 'config.php';
require_once 'middleware/Auth.php';
require_once 'controllers/AuthController.php';
require_once 'controllers/ProductController.php';
require_once 'controllers/OrderController.php';

$action = isset($_GET['action']) ? $_GET['action'] : 'index';
$id     = isset($_GET['id'])     ? (int)$_GET['id'] : null;

$authCtrl    = new AuthController($conn);
$productCtrl = new ProductController($conn);
$orderCtrl   = new OrderController($conn);

switch ($action) {

    case 'login':    $authCtrl->login();    break;
    case 'logout':   $authCtrl->logout();   break;
    case 'register': $authCtrl->register(); break;
    case 'users':    $authCtrl->users();    break;
    case 'delete_user':
        if ($id) $authCtrl->deleteUser($id);
        else     header("Location: index.php?action=users");
        break;

    case 'index':
        Auth::check(); $productCtrl->index(); break;
    case 'view':
        Auth::check();
        if ($id) $productCtrl->view($id);
        else     header("Location: index.php?action=index");
        break;
    case 'add':
        Auth::adminOnly(); $productCtrl->add(); break;
    case 'edit':
        Auth::adminOnly();
        if ($id) $productCtrl->edit($id);
        else     header("Location: index.php?action=index");
        break;
    case 'delete':
        Auth::adminOnly();
        if ($id) $productCtrl->delete($id);
        else     header("Location: index.php?action=index");
        break;
    case 'search':
        Auth::check(); $productCtrl->search(); break;

    case 'buy':
        if ($id) $orderCtrl->buy($id);
        else     header("Location: index.php?action=index");
        break;
    case 'order_success':
        if ($id) $orderCtrl->success($id);
        else     header("Location: index.php?action=index");
        break;
    case 'orders':
        $orderCtrl->allOrders(); break;
    case 'my_orders':
        $orderCtrl->myOrders(); break;
    case 'update_order_statut':
        if ($id) $orderCtrl->updateStatut($id);
        else     header("Location: index.php?action=orders");
        break;
    case 'delete_order':
        if ($id) $orderCtrl->deleteOrder($id);
        else     header("Location: index.php?action=orders");
        break;

    default:
        Auth::check(); $productCtrl->index(); break;
}

$conn->close();
?>
