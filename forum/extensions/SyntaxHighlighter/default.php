<?php
/*
Extension Name: SyntaxHighlighter
Extension Url: http://lussumo.com/addons
Description: Provides syntax highlighting for text in a [code][/code] block for posts and comments. Accepts the lang attribute, e.g. [code lang="css"] for CSS, lang="python" for Python. See readme.html in the SyntaxHighlighter folder for all options.
Version: 1.1.2
Author: thomasmallen
Author Url: http://www.cssforums.org/
*/

// Load the highlighter styles
$Head->AddStyleSheet('extensions/SyntaxHighlighter/styles/SyntaxHighlighter.css');

/**
 * Load the language scripts. Comment out any languages you don't need.
 */
$hlScripts = array(
    'shCore.js',            // REQUIRED

    'shBrushCpp.js',        // C++
    'shBrushCSharp.js',     // C# (C-Sharp)
    'shBrushCss.js',        // CSS
    'shBrushDelphi.js',     // Delphi
    'shBrushJava.js',       // Java
    'shBrushJScript.js',    // JavaScript
    'shBrushPhp.js',        // PHP
    'shBrushPython.js',     // Python
    'shBrushRuby.js',       // Ruby
    'shBrushSql.js',        // SQL
    'shBrushVb.js',         // VB (Visual Basic)
	'shBrushXml.js',        // XML
);

foreach($hlScripts as $script) {
    $Head->AddScript('extensions/SyntaxHighlighter/scripts/' . $script);
}

// Required SyntaxHighlighter palette initialization.
$syntaxHighlighterInit = <<<SCRIPT
<script type="text/javascript">
window.onload = function() {
    dp.SyntaxHighlighter.ClipboardSwf = "extensions/SyntaxHighlighter/scripts/clipboard.swf";
    dp.SyntaxHighlighter.HighlightAll("code");
}
</script>
SCRIPT;
$Head->AddString($syntaxHighlighterInit);

/**
 * SyntaxHighlighterFormatter
 * 
 * Parses $String, replacing [code] with <pre title="code">, [/code] with </pre>,
 * and [code lang="$langname"] with <pre title="code" class="$langname".
 * Relaces newlines with <br />
 * 
 * @return string Formatted string with [code] and \n replacements
 */

class SyntaxHighlighterFormatter extends StringFormatter {
    function Parse($String, $Object, $FormatPurpose) {
        if ($FormatPurpose == FORMAT_STRING_FOR_DISPLAY) {
            $hlString = $String;
            $hlString = htmlspecialchars($String, ENT_NOQUOTES);
            $hlString = preg_replace("/\[code( lang=\"([A-Za-z\+#]+)\")?\]/", 
                "<pre title=\"code\" class=\"$2\">", $hlString);
            $hlString = str_replace('[/code]', '</pre>', $hlString);
            // Replace newlines with <br />
            $hlString = preg_replace("#(?:\r\n|[\r\n])(?=(?:[^<]|<(?!/pre))*(?:<pre|\Z))#", 
                "<br />", $hlString);
			return $hlString;
        }
        else {
            return $String;
        }
    }
}

// Put the pieces together
$SyntaxHighlighterFormatter = $Context->ObjectFactory->NewObject($Context, 'SyntaxHighlighterFormatter');

// Add the SyntaxHighlighter option
$Context->StringManipulator->AddManipulator("SyntaxHighlighter", $SyntaxHighlighterFormatter);
?>
