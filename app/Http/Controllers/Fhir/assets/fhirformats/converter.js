// esegue codice in lua preso come parametro
function runLuaSafe(code) {
  var results = L.execute("return xpcall(function() return "+code+" end, function(e) return e..[[\n]]..debug.traceback() end)");
  if (results[0] === false) {
    console.log(code + '\n' + results.slice(1).join());
  } else {
    return results.slice(1);
  }
}

// funzione che prende in input il codice xml o json della risorsa
// e la converte rispettivamente in json e in xml utilizzando
// le funzioni Lua in_fhir_json e in_fhir_xml
function convert() {
  var code_content = $('#codeelem').text();
  var code_element = $('#codeelem');

  var code_format = {
    old: '', new: ''
  }

  // se la risorsa e' attualmente in formato xml allora la converto in json e viceversa

  if (code_element.hasClass("xml")) {
    code_format['old'] = 'xml';
    code_format['new'] = 'json';
  } else {
    code_format['old'] = 'json';
    code_format['new'] = 'xml';
  }

  var converted_text = runLuaSafe("in_fhir_" + code_format['new'] + "([[" + code_content + "]], {pretty = true})").join();
    
  // inserisco il nuovo codice convertito nella pagina
  code_element.text(converted_text);
    
  // modifico il syntax highlight per lo stile del codice
  code_element.addClass(code_format['new']).removeClass(code_format['old']);
  code_element.each(function(i, block) {
    hljs.highlightBlock(block);
  });

  // modifico il testo del bottone per la conversione
  $('#convert_button_text').text('Converti in ' + code_format['old'].toUpperCase());
}
