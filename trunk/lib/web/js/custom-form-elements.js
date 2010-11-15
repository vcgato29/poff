/*

CUSTOM FORM ELEMENTS

Created by Ryan Fait
www.ryanfait.com

The only thing you need to change in this file is the following
variables: checkboxHeight, radioHeight and selectWidth.

Replace the first two numbers with the height of the checkbox and
radio button. The actual height of both the checkbox and radio
images should be 4 times the height of these two variables. The
selectWidth value should be the width of your select list image.

You may need to adjust your images a bit if there is a slight
vertical movement during the different stages of the button
activation.

Visit http://ryanfait.com/ for more information.

*/

var checkboxHeight = "25";
var radioHeight = "25";
var selectWidth = "120";
var selectFilter = (Common.browser.name == 'mmsie' && Common.browser.version < 8)?'':'filter: alpha(opacity=0);';

/* No need to change anything after this */

document.write('<style type="text/css">input.custom_form_elements_styled { display: none; } select.custom_form_elements_styled { position: relative; width: ' + selectWidth + 'px; opacity: 0; ' + selectFilter + ' z-index: 5; }</style>');

var CustomFormElements = {
	init: function() {
		var inputs = document.getElementsByTagName("input"), span = Array(), textnode, option, active;
		for(a = 0; a < inputs.length; a++) {
			if((inputs[a].type == "checkbox" || inputs[a].type == "radio") && $(inputs[a]).hasClass('custom_form_elements_styled') && !$(inputs[a]).hasClass('already_transformed')) {
				span[a] = document.createElement("span");
				span[a].className = inputs[a].type;

				if(inputs[a].checked == true) {
					if(inputs[a].type == "checkbox") {
						position = "0 -" + (checkboxHeight*2) + "px";
						span[a].style.backgroundPosition = position;
					} else {
						position = "0 -" + (radioHeight*2) + "px";
						span[a].style.backgroundPosition = position;
					}
				}

				jQuery(inputs[a]).addClass('already_transformed');

				inputs[a].parentNode.insertBefore(span[a], inputs[a]);
				//inputs[a].onchange = CustomFormElements.clear;
				$(inputs[a]).bind('change', function(){CustomFormElements.clear();});
				span[a].onmousedown = CustomFormElements.pushed;
				span[a].onmouseup = CustomFormElements.check;
				document.onmouseup = CustomFormElements.clear;
			}
		}

		var s = document.getElementsByTagName('select');
        for (var i=0; i<s.length; i++) {
            CustomFormElements.selectReplacement(s[i]);
        }
	},
	pushed: function() {
		element = this.nextSibling;
		if(element.checked == true && element.type == "checkbox") {
			this.style.backgroundPosition = "0 -" + checkboxHeight*3 + "px";
		} else if(element.checked == true && element.type == "radio") {
			this.style.backgroundPosition = "0 -" + radioHeight*3 + "px";
		} else if(element.checked != true && element.type == "checkbox") {
			this.style.backgroundPosition = "0 -" + checkboxHeight + "px";
		} else {
			this.style.backgroundPosition = "0 -" + radioHeight + "px";
		}
	},
	check: function() {
		element = this.nextSibling;
		if(element.checked == true && element.type == "checkbox") {
			this.style.backgroundPosition = "0 0";
			element.checked = false;
		} else {
			if(element.type == "checkbox") {
				this.style.backgroundPosition = "0 -" + checkboxHeight*2 + "px";
			} else {
				this.style.backgroundPosition = "0 -" + radioHeight*2 + "px";
				group = this.nextSibling.name;
				inputs = document.getElementsByTagName("input");
				for(a = 0; a < inputs.length; a++) {
					if(inputs[a].name == group && inputs[a] != this.nextSibling) {
						inputs[a].previousSibling.style.backgroundPosition = "0 0";
					}
				}
			}
			element.checked = true;
		}
	},
	clear: function() {
		inputs = document.getElementsByTagName("input");
		for(var b = 0; b < inputs.length; b++) {
			if(inputs[b].type == "checkbox" && inputs[b].checked == true && inputs[b].className == "custom_form_elements_styled") {
				$(inputs[b]).prev().css('background-position',"0 -" + checkboxHeight*2 + "px");
			} else if(inputs[b].type == "checkbox" && inputs[b].className == "custom_form_elements_styled") {
			    $(inputs[b]).prev().css('background-position',"0 0");
			} else if(inputs[b].type == "radio" && inputs[b].checked == true && inputs[b].className == "custom_form_elements_styled") {
			    $(inputs[b]).prev().css('background-position',"0 -" + radioHeight*2 + "px");
			} else if(inputs[b].type == "radio" && inputs[b].className == "custom_form_elements_styled") {
				$(inputs[b]).prev().css('background-position',"0 0");
			}
		}
	},

	// --------- select ---------------

	selectReplacement : function(obj) {

	  if (!obj || $(obj).hasClass('already_transformed')) return

      // append a class to the select
      obj.className += ' replaced';
      // create list for styling
      var ul = document.createElement('ul');
      ul.className = 'selectReplacement';
      var opts = obj.options;
      for (var i=0; i<opts.length; i++) {
        var selectedOpt;
        if (opts[i].selected) {
          selectedOpt = i;
          break;
        } else {
          selectedOpt = 0;
        }
      }
      for (var i=0; i<opts.length; i++) {
        var li = document.createElement('li');
        var txt = document.createTextNode(opts[i].text);
        li.appendChild(txt);
        li.selIndex = opts[i].index;
        li.selectID = obj.id;
        li.onclick = function() {
          CustomFormElements.selectMe(this);
        }
        if (i == selectedOpt) {
          li.className = 'selected';
          li.onclick = function() {
            this.parentNode.className += ' selectOpen';
            this.onclick = function() {
              CustomFormElements.selectMe(this);
            }
          }
        }
        if (window.attachEvent) {
          li.onmouseover = function() {
            this.className += ' hover';
          }
          li.onmouseout = function() {
            this.className =
              this.className.replace(new RegExp(" hover\\b"), '');
          }
        }
        ul.appendChild(li);
      }
      // add the input and the ul
      obj.parentNode.appendChild(ul);

      $(obj).addClass('already_transformed');
    },
    selectMe: function(obj) {
      var lis = obj.parentNode.getElementsByTagName('li');

      for (var i=0; i<lis.length; i++) {
        if (lis[i] != obj) { // not the selected list item
          lis[i].className='';
          lis[i].onclick = function() {
            CustomFormElements.selectMe(this);
          }
       } else {
          CustomFormElements.setVal(obj.selectID, obj.selIndex);
          obj.className='selected';
          obj.parentNode.className =
            obj.parentNode.className.replace(new RegExp(" selectOpen\\b"), '');
          obj.onclick = function() {
            obj.parentNode.className += ' selectOpen';
            this.onclick = function() {
              CustomFormElements.selectMe(this);
            }
          }
        }
      }
    },
    setVal: function(objID, selIndex) {
      var obj = document.getElementById(objID);
      obj.selectedIndex = selIndex;
      $(obj).trigger('change');
    }
}



