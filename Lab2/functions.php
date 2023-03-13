<?php
function Check_URL_and_Get_ID()
{
    $url = $_SERVER['REQUEST_URI'];
    $urlItems = explode('/', $url);
    if (isset($urlItems[4]) && $urlItems[4] !== 'products') {
        Return_Response(404, ["error" => "DataBase Not Found"]);
        exit();
    }
    $product_id = isset($urlItems[5]) ? $urlItems[5] : null;
    return $product_id;
}

function Handle_request($handler, $product_id)
{
    $method = $_SERVER['REQUEST_METHOD'];
    switch ($method) {
        case "GET":
            get_all_products($handler, $product_id);
            break;
        case "POST":
            add_new_product($handler);
            break;
        case "PUT":
            update_product($handler, $product_id);
            break;
        case "DELETE":
            delete_product($handler, $product_id);
            break;
        default:
            Return_Response(405, ["error" => "method not allowed!"]);
    }
}
function Return_Response($code, $msg)
{
    header('Content-Type: application/json');
    http_response_code($code);
    echo json_encode($msg);
}
function get_all_products($handler, $product_id)
{
    if ($product_id) {
        $founded_Product = $handler->get_record_by_id($product_id);
        if ($founded_Product) {
            Return_Response(200, $founded_Product);
        } else {
            Return_Response(404, ["error" => "Product dose not exist"]);
        }
    } else {
        $all_data = $handler->get_data();
        Return_Response(200, $all_data);
    }
}

function add_new_product($handler)
{
    $body = file_get_contents('php://input'); //read the raw POST data from the request.
    if ($body) {
        $response = $handler->save(json_decode($body, true));
        if ($response) {
            Return_Response(200, ["success" => "product added successfully"]);
        } else {
            Return_Response(400, ["error" => "product add failed"]);
        }
    } else {
        Return_Response(400, ["error" => "Bad Request (no data)"]);
    }
}
function update_product($handler, $product_id)
{
    if ($product_id) {
        if ($handler->search("id", $product_id)) {
            $handler->connect(); //reconnect after close in search method
            $update = json_decode(file_get_contents('php://input'), true);
            $response = $handler->update($update, $product_id);
            if ($response) {
                Return_Response(200, ["success" => "product updated successfully"]);
            } else {
                Return_Response(400, ["error" => "product update failed"]);
            }
        } else {
            Return_Response(404, ["error" => "Product dose not exist"]);
        }
    } else {
        Return_Response(400, ["error" => "No Product Id to delete"]);
    }
}
function delete_product($handler, $product_id)
{
    if ($product_id) {
        $delete_flag = $handler->delete($product_id);
        if ($delete_flag) {
            Return_Response(200, ["success" => "product deleted successfully"]);
        } else {
            Return_Response(400, ["error" => "product delete failed"]);
        }
    } else {
        Return_Response(400, ["error" => "No Product Id to delete"]);
    }
}
