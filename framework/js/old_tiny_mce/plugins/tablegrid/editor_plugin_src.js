/**
 * editor_plugin_src.js
 *
 * Copyright 2009, Moxiecode Systems AB
 * Released under LGPL License.
 *
 * License: http://tinymce.moxiecode.com/license
 * Contributing: http://tinymce.moxiecode.com/contributing
 */

(function() {
    tinymce.PluginManager.requireLangPack('tablegrid');

    tinymce.create('tinymce.plugins.TableGrid', {
        createControl: function(n, cm) {
            var t = this, ed = t.ed;

            if (n === 'tablegrid') {
                var c = cm.createSplitButton('grid', {
                    title : 'tablegrid.create_table',
                    'image': t.url + '/img/table-grid.gif',
                    onclick : function() {
                        ed.execCommand('mceInsertTable');
                    }
                });

                // Not sure if this is the right way to do it.
                c.showMenu = function() {
                    t.ed.execCommand('openTableGridPopup');
                };
                return c;
            }
            return null;
        },

        init : function(ed, url) {
            var t = this, dom = tinymce.DOM;

            t.url = url;
            t.ed = ed;
            t.popupIsVisible = 0;
            t.tableGridSelectionBoookmark = null;

            ed.addCommand('openTableGridPopup', function() {
                t._showPopup();
            });

            ed.onClick.add(function(ed, e) {
                t._hidePopup();
            });

            // From the table plug-in.
            ed.onNodeChange.add(function(ed, cm, n) {
				var p;

				n = ed.selection.getStart();
				p = ed.dom.getParent(n, 'td,th,caption');
				cm.setActive('grid', n.nodeName === 'TABLE' || !!p);

				// Disable table tools if we are in caption
				if (p && p.nodeName === 'CAPTION')
					p = 0;

				cm.setDisabled('delete_table', !p);
				cm.setDisabled('delete_col', !p);
				cm.setDisabled('delete_table', !p);
				cm.setDisabled('delete_row', !p);
				cm.setDisabled('col_after', !p);
				cm.setDisabled('col_before', !p);
				cm.setDisabled('row_after', !p);
				cm.setDisabled('row_before', !p);
				cm.setDisabled('row_props', !p);
				cm.setDisabled('cell_props', !p);
				cm.setDisabled('split_cells', !p);
				cm.setDisabled('merge_cells', !p);
			});

            ed.onInit.add(function(ed, l) {
                dom.loadCSS(url + '/css/tablegrid.css');
                t._createPopup();
            });

            // Hide the popup when clicking outside of the grid.
            dom.bind(document, 'mousedown', function(e) {
                var popup = dom.getParent(e.target, '.tg-popup-container');
                var splitButton = e.target.id === ed.id + '_grid_open';

                if (!splitButton && !popup) {
                    t._hidePopup();
                }
            });
        },

        getInfo : function() {
            return {
                longname : 'Table Grid',
                author : 'thomas@mr-andersen.no',
                authorurl : 'http://www.mr-andersen.no.com',
                infourl : 'http://www.mr-andersen.no.com',
                version : '1.1'
            };
        },

        // Internal functions

        _createPopup : function() {
            var t = this, ed = t.ed, dom = tinymce.DOM;
            var table, tBody, tr, td, gridContainer, grid, footerContainer;

            table = dom.create('table', {
                'cellpadding' : 0,
                'cellspacing' : 0,
                'id' : ed.id + '-tg-popup-container',
                'class' : 'tg-popup-container',
                'style' : 'display:none'
            });

            tBody = dom.create('tbody');
            tr = dom.create('tr');
            td = dom.create('td');

            dom.add(table, tBody);
            dom.add(tBody, tr);
            dom.add(tr, td);

            gridContainer = dom.create('div', {
                'id' : ed.id + '-tg-grid-wrapper',
                'class' : 'tg-grid-wrapper'
            });

            grid = t._createGrid();

            tr = dom.create('tr');
            td = dom.create('td');

            footerContainer = dom.create('div', {
                'id' : ed.id + '-tg-popup-footer',
                'class' : 'tg-popup-footer'
            }, '0 x 0');

            dom.bind(footerContainer, 'mouseover', function(e) {
                var closeText = ed.getLang('tablegrid.close_grid');
                e.target.innerHTML = closeText;
                e.target.title = closeText;
            });

            dom.bind(footerContainer, 'click', function(e) {
                t._hidePopup();
            });

            dom.add(td, gridContainer);
            dom.add(gridContainer, grid);
            dom.add(tBody, tr);
            dom.add(tr, td);
            dom.add(td, footerContainer);
            dom.add(dom.select('body', document)[0], table);
        },

        _showPopup : function(c) {
            var t = this, ed = t.ed, dom = tinymce.DOM;
            var popup = dom.select('#' + ed.id + '-tg-popup-container', document)[0];

            // IE seems to loose the caret when the grid button is clicked.
            if (tinymce.isIE) {
                ed.focus();
                t.tableGridSelectionBoookmark = ed.selection.getBookmark();
            }

            if (t.popupIsVisible) {
                return t._hidePopup();
            }

            var splitButton = dom.select('#' + ed.id + '_grid', document)[0];
            var splitButtonPos = dom.getPos(splitButton, document.getElementsByTagName('body')[0]);
            var splitButtonRect = dom.getRect(splitButton);
            var popupTopPos = splitButtonPos.y + splitButtonRect.h;
            var popupLeftPos = splitButtonPos.x;
           
            dom.addClass(splitButton, 'mceSplitButtonSelected');
            dom.show(popup);
            dom.setStyles(popup, {
                'top' : (popupTopPos + 'px'),
                'left' : (popupLeftPos + 'px')
            });

            t.popupIsVisible = 1;
        },

        _hidePopup : function () {

            var t = this, ed = t.ed, dom = tinymce.DOM;
            var popup = dom.select('#' + ed.id + '-tg-popup-container', document)[0];
            var splitButton = dom.select('#' + ed.id + '_grid', document)[0];

            if (!popup) {
                return;
            }

            dom.removeClass(splitButton, 'mceSplitButtonSelected');
            dom.hide(popup);
            t._clearGrid();
            t.popupIsVisible = 0;
        },

        _createGrid : function() {
            var t = this, ed = t.ed, dom = tinymce.DOM, trElement, tdElement, tbodyElement, i, j;
            var gridRowSize = parseInt(ed.getParam('tablegrid_row_size')) || 10;
            var gridColSize = parseInt(ed.getParam('tablegrid_col_size')) || 10;
            var tableElement = dom.create('table', {
                'class': 'tg-grid',
                'cellSpacing' : 1,
                'cellPadding' : 0
            });

            tbodyElement = dom.create('tbody');

            for (i = 0; i < gridRowSize; i++) {
                trElement = dom.create('tr', {});
                dom.add(tbodyElement, trElement);

                for (j = 0; j < gridColSize; j++) {
                    tdElement = t._createCell(i, j);
                    dom.add(trElement, tdElement);
                }
            }

            dom.add(tableElement, tbodyElement);

            return tableElement;
        },

        _createCell : function (rowIndex, columnIndex) {
            var t = this, ed = t.ed, dom = tinymce.DOM, rowLn, cellLn;
            var tdElement = dom.create('td');
            var aElement = dom.create('a', {
                'row' : rowIndex,
                'col' : columnIndex,
                'class' : 'tg-blank'
            }, '');

            dom.add(tdElement, aElement);

            dom.bind(aElement, 'mouseover', function(e) {
                t._fillCells(e.target);
            }, document);

            dom.bind(aElement, 'click', function(e) {
                rowLn = parseInt(dom.getAttrib(e.target, 'row')) + 1;
                cellLn = parseInt(dom.getAttrib(e.target, 'col')) + 1;

                t._insert(rowLn, cellLn);
                t._hidePopup();
            }, document);

            return tdElement;
        },

        _fillCells: function (selected) {
            var t = this, ed = t.ed, dom = tinymce.DOM;
            var popup = dom.select('#' + ed.id + '-tg-popup-container', document)[0];
            var gridWrapper = dom.select('#' + ed.id + '-tg-grid-wrapper', document)[0];
            var footer = dom.select('#' + ed.id + '-tg-popup-footer', popup)[0];
            var trElements = dom.select('tr', gridWrapper);
            var rowStop = parseInt(dom.getAttrib(selected, 'row')) + 1, colStop = parseInt(dom.getAttrib(selected, 'col')) + 1;
            var aElements, i, j;

            for (i = 0; i < trElements.length; i++) {

                aElements = dom.select('a', trElements[i]);

                for (j = 0; j < aElements.length; j++) {
                    if (j < colStop && i < rowStop) {
                        dom.setAttrib(aElements[j], 'class', 'tg-fill-color');
                        footer.innerHTML = (i + 1) + ' x ' + (j + 1);
                    } else {
                        dom.setAttrib(aElements[j], 'class', 'tg-blank');
                    }
                }
            }
        },

        _clearGrid: function() {
            var t = this, ed = t.ed, dom = tinymce.DOM, i;
            var popup = dom.select('#' + ed.id + '-tg-popup-container', document)[0];
            var footer = dom.select('#' + ed.id + '-tg-popup-footer', popup)[0];
            var aElements = dom.select('a', popup);
            footer.innerHTML = '0 x 0';

            dom.setAttrib(aElements, 'class', 'tg-blank');
        },

        _insert : function(rowsLn, colsLn) {
            var t = this, ed = t.ed, dom = ed.dom, selection = ed.selection, i, j;
            var html = '<table border="0" class="mceItemTable" _mce_new="1">\n';

            html += '<tbody>\n';

            for (i = 0; i < rowsLn; i++) {
                html += '<tr>\n';

                for (j = 0; j < colsLn; j++) {
                    if (!tinymce.isIE) {
                        html += '<td><br _mce_bogus="1" /></td>\n';
                    }
                    else {
                        html += '<td></td>\n';
                    }
                }

                html += '</tr>\n';
            }

            html += '</tbody>\n';
            html += '</table>\n';

            if (tinymce.isIE) {
                ed.selection.moveToBookmark(t.tableGridSelectionBoookmark);
            }

            // From plugins/js/table.js
            ed.execCommand('mceBeginUndoLevel');

            // Move table
            if (ed.settings.fix_table_elements) {
                var patt = '';

                ed.focus();
                ed.selection.setContent('<br class="_mce_marker" />');

                tinymce.each('h1,h2,h3,h4,h5,h6,p'.split(','), function(n) {
                    if (patt)
                        patt += ',';

                    patt += n + ' ._mce_marker';
                });

                tinymce.each(ed.dom.select(patt), function(n) {
                    ed.dom.split(ed.dom.getParent(n, 'h1,h2,h3,h4,h5,h6,p'), n);
                });

                dom.setOuterHTML(dom.select('br._mce_marker')[0], html);
            } else {
                ed.execCommand('mceInsertContent', false, html);
            }

            tinymce.each(dom.select('table[_mce_new]'), function(node) {
                var td = dom.select('td', node);
                ed.selection.select(td[0], true);
                ed.selection.collapse(true);

                dom.setAttrib(node, '_mce_new', '');
            });

            ed.addVisual();
            ed.execCommand('mceEndUndoLevel');
        }
    });

    tinymce.PluginManager.add('tablegrid', tinymce.plugins.TableGrid);
})();