(function()
{
	tinymce.PluginManager.requireLangPack('tableextras');
	
    tinymce.create('tinymce.plugins.TableExtrasPlugin', {

        init : function( ed, url )
        {
			tinymce.DOM.loadCSS( url + '/css/tableextras.css');

			var configuration = {
				rowSize: ed.getParam('tableextras_row_size') || 7,
				colSize: ed.getParam('tableextras_col_size') || 7
			};
			// -----------------------------------------------------------------

            ed.addCommand('teCmdTableDraw', function()
            {
				var elemPanel = document.getElementById('te-panel');
				
				if ( !elemPanel || elemPanel.style.display == 'none' )
					_displayTablePanel(ed);
				else
					_hideTablePanel();
            });
			// -----------------------------------------------------------------
			
			tinymce.dom.Event.add(document, 'mousedown', function(e) {
				if ( e.target.parentNode.id !== (ed.id + '_tabledraw') )
				{
					if ( !ed.dom.getParent(e.target, 'div') )
					{
						_hideTablePanel();
						return;
					}
					
					if ( ed.dom.getParent(e.target, 'div').id !== 'te-table-border-color' )
						_hideTablePanel();
				}
			});
			// -----------------------------------------------------------------

            ed.addCommand('teCmdConvertCellsInRow', function()
            {
				_convertCellsInRow(ed);
            });
			// -----------------------------------------------------------------

            ed.addButton('convertcellsinrow', {
                title: 'tableextras.convertcellsinrow',
                cmd: 'teCmdConvertCellsInRow',
                image: url + '/img/convert.gif'
            });
			// -----------------------------------------------------------------

            ed.addButton('tabledraw', {
                title: 'tableextras.tabledraw',
                cmd: 'teCmdTableDraw',
                image: url + '/img/table.gif'
            });
			// -----------------------------------------------------------------

            ed.onClick.add(function( ed )
            {
                _hideTablePanel();
            });
			// -----------------------------------------------------------------

            ed.onNodeChange.add(function( ed, cm, n )
            {
                cm.setDisabled('convertcellsinrow',
							   (n.nodeName != 'TD' && n.nodeName != 'TH'));
            });
			// -----------------------------------------------------------------

            function _displayTablePanel( ed )
            {
				// IE seems to loose the cursor position when the button is clicked, so we must store it
				// for the insertTable method.
				if ( tinymce.isIE )
				{
					tinyMCE.activeEditor.objSelectionBoookmark = tinyMCE.activeEditor.selection.getBookmark();
				}

                var elemPanel;
                
				elemPanel = document.getElementById('te-panel');

                if ( !elemPanel )
				{
					elemPanel = _createPanel( ed );
					document.getElementsByTagName('body')[0].appendChild(elemPanel);																
				}
				
				var controlTableButton = ed.controlManager.get('tabledraw');
				
                var elemTableButton = document.getElementById(controlTableButton.id);

                var objButtonRect = ed.dom.getRect(elemTableButton);
				elemPanel.controlButton = controlTableButton;
				
				var topPositionToPlacePanel = objButtonRect.y + objButtonRect.h;
				
				// I don't no if this is a bug with getRect, but for IE it does not count the scroll position.
				if ( tinymce.isIE ) topPositionToPlacePanel = topPositionToPlacePanel + _getScrollXY()[1];
					
                elemPanel.style.top = topPositionToPlacePanel + 'px';
                elemPanel.style.left = objButtonRect.x + 'px';
                elemPanel.style.display = 'block';
				controlTableButton.setActive(true);

                _clearTable();
            };
			// -----------------------------------------------------------------

            function _hideTablePanel()
            {
                var elemPanel = document.getElementById('te-panel');
                if ( !elemPanel ) return;
                elemPanel.style.display = 'none';
				
				elemPanel.controlButton.setActive(false);
            };
			// -----------------------------------------------------------------

            function _fillCells( elemSelectedCell )
            {
                var elemTable = document.getElementById('te-panel');

                var nlRows = elemTable.getElementsByTagName('tr');
				var intRowsLn = nlRows.length;

                var rowStop = elemSelectedCell.row + 1, colStop = elemSelectedCell.col + 1;

                var nlCells, intCellsLn;

                for ( var i = 0; i < intRowsLn; i++ )
                {
                    nlCells = nlRows[i].getElementsByTagName('td');
                    intCellsLn = nlCells.length;

                    for ( var j = 0; j < intCellsLn; j++ )
                    {
                        if ( j < colStop && i < rowStop )
                        {
                            nlCells[j].className = 'fill';
                            document.getElementById('te-info').innerHTML = (i + 1) + ' x ' + (j + 1);
                        }
                        else
						{
                            nlCells[j].className = 'blank';
						}
                    }
                }
            };
			// -----------------------------------------------------------------

            function _clearTable()
            {
                var elemTable = document.getElementById('te-panel');
                var nlCells = elemTable.getElementsByTagName('td');
                var intCellsLn = nlCells.length;

                for ( var i = 0; i < intCellsLn; i++ )
				{
                    nlCells[i].className = 'blank';
				}
            };
			// -----------------------------------------------------------------

			function _createPanel( ed )
			{
				var elemPanel = _createElement('div', {
					id: 'te-panel'
				});
	
				var elemTableWrapper = _createElement('div', {
					id: 'te-table-border-color'
				});
	
				var elemTable = _createTable();
	
				var elemInfo  = _createElement('div', {
					id: 'te-info'
				});
				
				elemInfo.innerHTML = '0 x 0';
				
				elemInfo.onmouseover = function()
				{
					var strClose = ed.getLang('tableextras.tabledrawclose');
					this.innerHTML = strClose;
					this.title = strClose;
				};
	
				elemInfo.onclick = function()
				{
					_hideTablePanel();
				};
	
				elemPanel.appendChild(elemTableWrapper);
				elemTableWrapper.appendChild(elemTable);
				elemPanel.appendChild(elemInfo);

				return elemPanel;		
			}
			// -----------------------------------------------------------------

            function _createTable()
            {
				var elemTable = _createElement('table', {
					id: 'te-table',
					border: '0',
					cellSpacing: 1,
					cellPadding: 1
				});

				var elemTBody = _createElement('tbody', {});
                var intRowsLn = configuration.rowSize, intColsLn = configuration.colSize;
				var elemTr, elemTd;

                for ( var i = 0; i < intRowsLn; i++ )
                {
					elemTr = _createElement('tr', {});
					elemTBody.appendChild(elemTr);

                    for ( var j = 0; j < intColsLn; j++ )
                    {
						elemTd = _createCell(i, j);
                        elemTr.appendChild(elemTd);
                    }
                }

                elemTable.appendChild(elemTBody);

                return elemTable;
            };
			// -----------------------------------------------------------------

			function _createCell(i, j)
			{
				var elemTd = _createElement('td', {
					row: i,
					col: j
				});

				elemTd.onmouseover = function()
				{
					_fillCells(this);
				};

				elemTd.onmouseout = function()
				{
					_fillCells(this);
				};

				elemTd.onclick = function()
				{
					_insertTableToEditorDocument((this.row + 1), (this.col + 1));
					_hideTablePanel();
				};
				
				return elemTd;
			};
			// -----------------------------------------------------------------

            function _insertTableToEditorDocument( rowsLn, colsLn )
            {
				var editor = tinyMCE.activeEditor;
				var dom = editor.dom;
				
                var strHtml = '<table border="0" class="mceItemTable">\n';

                strHtml += '<tbody>\n';
                
				for ( var i = 0; i < rowsLn; i++ )
                {
                    strHtml += '<tr>\n';

                    for ( var j = 0; j < colsLn; j++ )
                    {
                        strHtml += '<td>&nbsp;</td>\n';
                    }
                    strHtml += '</tr>\n';
                }

                strHtml += '</tbody>\n';
                strHtml += '</table>\n';
				
				// Move the cursor to the position stored when the table button was clicked.
				if ( tinymce.isIE )
				{
					editor.selection.moveToBookmark(editor.objSelectionBoookmark);
				}
				
				if ( editor.settings.fix_table_elements ) {
					var objBookmark = editor.selection.getBookmark(), strPatt = '';
			
					editor.execCommand('mceInsertContent', false, '<br class="_mce_marker" />');
			
					tinymce.each( 'h1,h2,h3,h4,h5,h6,p'.split(','), function(n) {
						if (strPatt)
							strPatt += ',';
			
						strPatt += n + ' ._mce_marker';
					});
			
					tinymce.each( dom.select(strPatt), function(n) {
						dom.split(dom.getParent(n, 'h1,h2,h3,h4,h5,h6,p'), n);
					});
			
					dom.setOuterHTML(editor.dom.select('._mce_marker')[0], strHtml);
					editor.selection.moveToBookmark(objBookmark);
				}
				else
				{
					editor.execCommand('mceInsertContent', false, strHtml);
				}
				editor.addVisual();

            };
			// -----------------------------------------------------------------

			function _createElement(strElemName, objAttributes)
			{
				var elem = document.createElement(strElemName);
				
				for ( var i in objAttributes )
				{
					if ( i  == 'style' )
					{
						elem[i].cssText = objAttributes[i];
					}
					else
					{
						elem[i] = objAttributes[i];
					}
				}
				
				return elem;
			};
			// -----------------------------------------------------------------
			
			function _getSelectedIndex( elemSelectedNode, nl )
			{
				var intSelectedIndex = 0;
				var nlLn = nl.length;
				for ( var i = 0; i < nlLn; i++ )
				{
					if ( nl[i].nodeName === 'TD' || nl[i].nodeName === 'TH' )
					{
						if ( nl[i] === elemSelectedNode )
						{
							break;	
						}
						intSelectedIndex++;
					}
				}
				return intSelectedIndex;
			};
			// -----------------------------------------------------------------	
			
			function _getScrollXY() {
				var scrOfX = 0, scrOfY = 0;
				if( typeof( window.pageYOffset ) === 'number' )
				{
					//Netscape compliant
					scrOfY = window.pageYOffset;
					scrOfX = window.pageXOffset;
				}
				else if( document.body && ( document.body.scrollLeft || document.body.scrollTop ) )
				{
					//DOM compliant
					scrOfY = document.body.scrollTop;
					scrOfX = document.body.scrollLeft;
				}
				else if( document.documentElement && ( document.documentElement.scrollLeft || document.documentElement.scrollTop ) )
				{
					//IE6 standards compliant mode
					scrOfY = document.documentElement.scrollTop;
					scrOfX = document.documentElement.scrollLeft;
				}
				return [ scrOfX, scrOfY ];
			};
			// -----------------------------------------------------------------
			
            function _convertCellsInRow( ed )
            {
                var objSelection = ed.selection;
				var elemSelectedNode = objSelection.getNode();
                var boolIsTDelement;
				var elemTr;
				
				if ( elemSelectedNode.nodeName != 'TD' && elemSelectedNode.nodeName != 'TH' ) return;

                elemTr = ed.dom.getParent(elemSelectedNode, 'tr');
                
				if ( !elemTr ) return;
				
				boolIsTDelement = elemSelectedNode.nodeName == 'TD';
				
				// This could be done with a regEx, but since IE can not write to table elements we have to use the DOM way.
				var nl = elemTr.childNodes;
				var nlLn = nl.length;

				var elemNewTr = ed.dom.create('tr');
				elemNewTr = _copyAttributesToElement(elemTr, elemNewTr);

				var intSelectedIndex = _getSelectedIndex( elemSelectedNode, nl);
				var strNewElementName = boolIsTDelement ? 'th' : 'td';

				for ( var i = 0; i < nlLn; i++ )
				{
					if ( nl[i].nodeName === 'TD' || nl[i].nodeName === 'TH')
					{
						var elemNew = ed.dom.create(strNewElementName);
						elemNew = _copyAttributesToElement(nl[i], elemNew );
						elemNew.innerHTML = nl[i].innerHTML;
						elemNewTr.appendChild(elemNew);
					}
				}

				elemTr.parentNode.insertBefore(elemNewTr, elemTr);
				elemTr.parentNode.removeChild(elemTr);
				
				var elemSelectedElement = elemNewTr.getElementsByTagName(strNewElementName)[intSelectedIndex];
				
				// Fix for IE.
				var elemToSelect = tinymce.isIE ? elemSelectedElement : elemSelectedElement.firstChild || elemSelectedElement;
				
				objSelection.select( elemToSelect );
				objSelection.collapse(0);
            };
			// -----------------------------------------------------------------
			
			function _copyAttributesToElement( elemFrom, elemTo )
			{
				var elemFromAttributes = elemFrom.attributes;
				var elemFromAttributesLn = elemFromAttributes.length;
				for ( var i = 0; i < elemFromAttributesLn; i++ )
				{
					if ( elemFromAttributes[i].nodeName === 'style' )
					{
						elemTo.style.cssText = elemFrom.style.cssText;
					}
					else
					{
					// IE adds the attributes even when they are empty|null.
					if ( elemFromAttributes[i].nodeValue )
						ed.dom.setAttrib(elemTo, elemFromAttributes[i].nodeName, elemFromAttributes[i].nodeValue);
					}
				}
				return elemTo;
			};
        },
		// ---------------------------------------------------------------------				
        
		getInfo : function()
        {
            return {
                longname : 'Table Extras plugin',
                author : 'tan@enonic.com',
                authorurl : 'http://www.enonic.com',
                infourl : 'http://www.enonic.com',
                version : '1.4.0'
            };
        }
    });

    tinymce.PluginManager.add('tableextras', tinymce.plugins.TableExtrasPlugin);
})();