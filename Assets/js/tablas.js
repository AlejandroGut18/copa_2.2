
/* Exportar <span> / Imprimir<span> */

// document.addEventListener("DOMContentLoaded", function () {
//   // Exportar a Excel
//   document
//     .getElementById("btnExportarExcelGrupos")
//     .addEventListener("click", function () {
//       exportarTablaAExcel("tblGrupos", "Clasificación_Grupos");
//     });

//   // Imprimir
//   document
//     .getElementById("btnImprimirGrupos")
//     .addEventListener("click", function () {
//       imprimirTablaGrupos();
//     });
// });

// Exportar tabla a Excel con soporte para caracteres especiales y acentos
function exportarTablaAExcel(tablaID, nombreArchivo = "") {
  var tabla = document.getElementById(tablaID);
  if (!tabla) return;
  var nombre = nombreArchivo ? nombreArchivo : "excel_data";
  var html = tabla.outerHTML;

  // Agregar estilo para centrar el contenido de las celdas
  var estilo = `
            <style>
                table, th, td {
                    text-align: center !important;
                    vertical-align: middle !important;
                }
            </style>
        `;

  // Encabezado para idioma español y charset UTF-8
  var contenido = `
            <html xmlns:o="urn:schemas-microsoft-com:office:office"
                xmlns:x="urn:schemas-microsoft-com:office:excel"
                xmlns="http://www.w3.org/TR/REC-html40">
            <head>
                <!--[if gte mso 9]>
                <xml>
                    <x:ExcelWorkbook>
                        <x:ExcelWorksheets>
                            <x:ExcelWorksheet>
                                <x:Name>${nombre}</x:Name>
                                <x:WorksheetOptions>
                                    <x:DisplayGridlines/>
                                </x:WorksheetOptions>
                            </x:ExcelWorksheet>
                        </x:ExcelWorksheets>
                    </x:ExcelWorkbook>
                </xml>
                <![endif]-->
                <meta charset="UTF-8">
                <meta http-equiv="Content-Language" content="es" />
                ${estilo}
            </head>
            <body>
                ${html}
            </body>
            </html>
        `;

  var blob = new Blob([contenido], {
    type: "application/vnd.ms-excel;charset=utf-8;",
  });
  var url = URL.createObjectURL(blob);
  var a = document.createElement("a");
  a.href = url;
  a.download = nombre + ".xls";
  document.body.appendChild(a);
  a.click();
  document.body.removeChild(a);
  setTimeout(function () {
    URL.revokeObjectURL(url);
  }, 100);
}

function imprimirTablaGrupos() {
  var tabla = document.getElementById("tblGrupos");
  if (!tabla) return;
  var ventana = window.open("", "", "height=600,width=900");
  ventana.document.write(
    "<html><head><title>Imprimir Clasificación por Grupos</title>"
  );
  ventana.document.write(
    '<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">'
  );
  ventana.document.write(
    "<style>body{text-align:center;} table{margin-left:auto;margin-right:auto;} th,td{text-align:center;vertical-align:middle;}</style>"
  );
  ventana.document.write("</head><body>");
  ventana.document.write("<h3>Clasificación por Grupos</h3>");
  ventana.document.write(tabla.outerHTML);
  ventana.document.write("</body></html>");
  ventana.document.close();
  ventana.focus();
  ventana.print();
  ventana.close();
}
