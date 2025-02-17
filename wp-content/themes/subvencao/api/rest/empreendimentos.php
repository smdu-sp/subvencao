<?php
// Endpoint para carregar no mapa os point features dos empreendimentos
add_action('rest_api_init', function () {
    register_rest_route('api/v1', '/empreendimentos/', [
        'methods' => 'GET',
        'callback' => 'get_empreendimentos_data',
    ]);
});

function get_empreendimentos_data(WP_REST_Request $request)
{
    $transparencia = get_page_by_path('transparencia');
    $subvencionadosArray = get_field('subvencionados', $transparencia);
    $response = Array();

    foreach ($subvencionadosArray as $key => $dados) {
        $chamamento = $dados['chamamento'];
        $subvencionado = $dados['subvencionado'];

        array_push($response, Array(
            'nome' => $subvencionado['empreendimento']['nome'],
            'endereco' => $subvencionado['imovel']['endereco'],
            'latitude' => $subvencionado['coordenadas']['latitude'],
            'longitude' => $subvencionado['coordenadas']['longitude'],
            'chamamento' => $chamamento['processo']['value']
        ));
    }

    if (empty($response)) {
        return new WP_Error('no_data', 'Nenhum empreendimento encontrado.', array('status' => 404));
    }

    return new WP_REST_response($response);
}
