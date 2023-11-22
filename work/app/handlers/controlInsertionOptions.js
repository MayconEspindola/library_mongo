function controlInsertionOptions() {
    var termoInput = document.getElementById('termo');
    var tipoPesquisaSelect = document.getElementById('tipoPesquisa');

    if (termoInput.value.trim() !== '') {
        // Se algo for escrito, desabilita o campo de seleção
        tipoPesquisaSelect.disabled = true;
    } else {
        // Se o campo estiver vazio, habilita o campo de seleção
        tipoPesquisaSelect.disabled = false;
    }
}