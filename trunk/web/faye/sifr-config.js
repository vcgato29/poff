var inter = { src: 'inter.swf' };
var interactive = { src: 'inter.swf' };
var intermenu = { src: 'inter.swf' };
var intermenuactive = { src: 'inter.swf' };


    // You probably want to switch this on, but read <http://wiki.novemberborn.net/sifr3/DetectingCSSLoad> first.
    // sIFR.useStyleCheck = true;
    sIFR.activate(inter, interactive, intermenu, intermenuactive);

    sIFR.replace(inter, {
	   wmode: 'transparent',
      fitExactly: true, 
      selectable: true, 
      wmode: 'transparent', 
      forceClear: true,
	   selector: '.inter'
      ,css: [
        '.sIFR-root { font-weight: normal; color:#666666; font-size:14px;}'
        ,'a { text-decoration: none; }'
        ,'a:link { color: #666666; }'
        ,'a:hover { color: #ffffff; }'
      ]
    });
	
	
	sIFR.replace(interactive, {
	   wmode: 'transparent',
      fitExactly: true, 
      selectable: true, 
      wmode: 'transparent', 
      forceClear: true,
	   selector: '.interactive'
      ,css: [
        '.sIFR-root { font-weight: normal; color:#ffffff; font-size:14px;}'
        ,'a { text-decoration: none; }'
        ,'a:link { color: #ffffff; }'
        ,'a:hover { color: #ffffff; }'
      ]
    });
	 
	 sIFR.replace(intermenu, {
	   wmode: 'transparent',
      fitExactly: true, 
      selectable: true, 
      wmode: 'transparent', 
      forceClear: true,
	   selector: '.intermenu'
      ,css: [
        '.sIFR-root { font-weight: normal; color:#666666; font-size:12px;}'
        ,'a { text-decoration: none; }'
        ,'a:link { color: #666666; }'
        ,'a:hover { color: #ffffff; }'
      ]
    });
	sIFR.replace(intermenuactive, {
	   wmode: 'transparent',
      fitExactly: true, 
      selectable: true, 
      wmode: 'transparent', 
      forceClear: true,
	   selector: '.intermenuactive'
      ,css: [
        '.sIFR-root { font-weight: normal; color:#ffffff; font-size:12px;}'
        ,'a { text-decoration: none; }'
        ,'a:link { color: #ffffff; }'
        ,'a:hover { color: #ffffff; }'
      ]
    });
	 