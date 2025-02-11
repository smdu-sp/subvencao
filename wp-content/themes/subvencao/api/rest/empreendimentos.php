<?php
// Endpoint para carregar no mapa os point features dos empreendimentos
add_action('rest_api_init', function () {
    register_rest_route('api/v1', '/empreendimentos/', [
        'methods' => 'GET',
        'callback' => 'get_empreendimentos_data',
    ]);
});

function get_empreendimentos_data(WP_REST_Request $request) {
    global $wpdb;

    $results = $wpdb->get_results(
        "SELECT nome, endereco, latitude, longitude, chamamento FROM empreendimentos",
        ARRAY_A
    );

    if (empty($results)) {
        return new WP_Error('no_data', 'Nenhum empreendimento encontrado.', array('status' => 404));
    }
    
    return rest_ensure_response($results);
}
