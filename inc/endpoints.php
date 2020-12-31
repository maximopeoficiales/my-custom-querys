<?php
/* Aqui registro endpoints */
function mcqGetResultsByQuery()
{
    global $wpdb;
    $query = $_POST["query"];
    $user = $_POST["user"];
    $pass = $_POST["pass"];
    if ($user == "123456" && $pass == "123456") {
        try {
            $results = $wpdb->get_results(($query));
            return ["status" => 200, "data" => $results];
        } catch (\Throwable $th) {
            return ["status" => 404, "message" => $th];
        }
    } else {
        return ["status" => 404, "message" => "Credenciales Incorrectas"];
    }
}
// http://tudominio.com/wp-json/my_custom_query/v1/query
add_action("rest_api_init", function () {
    register_rest_route("my_custom_query/v1", "/query", array(
        "methods" => "POST",
        "callback" => "mcqGetResultsByQuery",
        'args'            => array(),
    ));
});
