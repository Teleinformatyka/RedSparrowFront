$(function() {

    var data = { 
                id: 12,
                id_pracy: "id_pracy",
                podobne_line: [
                       { "id_pracy": {
                          "linia": [2, 4],
                          "slowa_w_lini": [2, 4]
                        },
                         "id_plagiatu_1": {
                          "linia": [2, 4],
                          "slowa_w_lini": [2, 4]
                        },
                         "id_plagiatu_3": {
                          "linia": [2, 4],
                          "slowa_w_lini": [2, 4]
                        } }, 
                        {
                         "id_pracy2": {
                         "linia": [2, 4],
                         "slowa_w_lini": [2, 4]
                        }, 
                         "id_plagiatu_11": {
                          "linia": [2, 4],
                          "slowa_w_lini": [2, 4]
                        },
                          "id_plagiatu_23": {
                          "linia": [2, 4],
                          "slowa_w_lini": [2, 4]
                        }  }], 
                         stats: [ 
                         {  'nazwa': 'Plagiat#1233', 
                            'procentowy_wynik_analizy_podobientsta': 0.8, 
                            'liczba_podobnych_slow': 103, 
                            'podobienstwo_slow_kluczowych': 0.7} ]
                        }

    Morris.Bar({
        element: 'plagism-bar-chart',
        data: data.stats,
        ymax: '1',
        xkey: 'nazwa',
        ykeys: ['procentowy_wynik_analizy_podobientsta', /* 'liczba_podobnych_slow', 'podobienstwo_slow_kluczowych'*/],
        labels: ['procentowy_wynik_analizy_podobientsta', /*'liczba_podobnych_slow', 'podobienstwo_slow_kluczowych' */],
        hideHover: 'auto',
        resize: true
    });

});
