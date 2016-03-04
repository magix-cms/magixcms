## Critical plugin directory

Same directory as the theme plugin directory but you should only put the scss files which contain styles for elements displayed above the floating line.

Add here the *.scss* files located in the scss directory of your plugins.

Then add the line ```@import "custom/critical/plugins/_pluginName";``` per plugin sccs file in the *critical.scss* file.