<?php
	if(!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == "" || $_SERVER['HTTPS'] == "off"){
    header("HTTP/1.1 301 Moved Permanently");
    header("Location: https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>LatinBot</title>
		<style type="text/css">
			.input {
				display: none;
				margin: 5px;
				padding: 10px;
				background-color: rgb(225, 225, 225);
			}
			
			.l2inp {
				margin-bottom: 2px;
			}
			
			.head {
				display: table;
				margin-left: auto;
				margin-right: auto;
				margin-top: 10px;
				margin-bottom: 10px;
				font-size: 24pt;
				font-weight: bolder;
				font-family: "Times New Roman", Times, serif;
			}
			
			html {
				min-width: 100%;
				min-height: 100%;
			}
			
			body {
				padding: 0px;
				margin: 5px;
				border: 4px double;
				padding: 10px;
			}
		</style>
		<script type="text/javascript"><!--
			cfg = {};
			
			cfg.client = {};
			cfg.client.verb = {};
			cfg.client.verb.predictive = false;
			cfg.client.noun = {};
			cfg.client.noun.predictive = false;
			
			cfg.server = {};
			cfg.server.enabled = true;
			cfg.server.verb = {};
			cfg.server.verb.noParticipleMode = 0;
			cfg.server.verb.participlePrinciplePartMode = 1;
			
			function verbPPchange(ppid) {
				if(!cfg.client.verb.predictive) {
					return;
				}
				pp1verb = document.getElementById("pp1verb");
				pp2verb = document.getElementById("pp2verb");
				pp3verb = document.getElementById("pp3verb");
				pp4verb = document.getElementById("pp4verb");
				
				if(ppid == 1) {
					if(pp1verb.value.endsWith('o')) {
						pp2verb.value = pp1verb.value.substring(0, pp1verb.value.length - 1);
						
						if(pp1verb.value.endsWith('eo')) {
							pp2verb.value += 're';
							pp3verb.value = pp1verb.value.substring(0, pp1verb.value.length - 2) + 'ui';
						}
					}
				} else if(ppid == 2) {
					if(pp2verb.value.endsWith('are')) {
						pp3verb.value = pp2verb.value.substring(0, pp2verb.value.length - 2) + 'vi';
						pp4verb.value = pp2verb.value.substring(0, pp2verb.value.length - 2) + 'tum';
					}
				} else if(ppid == 3) {
					if(pp3verb.value.endsWith('i')) {
						pp4verb.value = pp3verb.value.substring(0, pp3verb.value.length - 2) + "tum";
					}
				}
			}
			
			function nounPPchange(ppid) {
				if(!cfg.client.noun.predictive) {
					return;
				}
				pp1noun = document.getElementById("pp1noun");
				pp2noun = document.getElementById("pp2noun");
				pp3noun = document.getElementById("pp3noun");
				
				if(ppid == 1) {
					if(pp1noun.value.endsWith('a')) {
						pp2noun.value = pp1noun.value + 'e';
						pp3noun.value = 'f';
						return;
					} else if(pp1noun.value.endsWith('uer') || pp1noun.value.endsWith('ir')) {
						pp2noun.value = pp1noun.value + 'i';
						pp3noun.value = 'm';
						return;
					} else if(pp1noun.value.endsWith('er')) {
						newEnding = 'ri';
						gender = 'm';
					} else if(pp1noun.value.endsWith('us')) {
						newEnding = 'i';
						gender = 'm';
					} else if(pp1noun.value.endsWith('um')) {
						newEnding = 'i';
						gender = 'n';
					} else if(pp1noun.value.endsWith('or')) {
						pp2noun.value = pp1noun.value + 'is';
						pp3noun.value = 'm';
						return;
					} else if(pp1noun.value.endsWith('is')) {
						newEnding = 'is';
						gender = pp3noun.value;
					} else if(pp1noun.value.endsWith('tas')) {
						newEnding = 'atis';
						gender = 'f';
					} else if(pp1noun.value.endsWith('tudo')) {
						newEnding = 'dinis';
						gender = 'f';
					} else if(pp1noun.value.endsWith('ar')) {
						newEnding = 'aris';
						gender = 'n';
					} else if(pp1noun.value.endsWith('al')) {
						newEnding = 'alis';
						gender = 'n';
					} else {
						newEnding = '';
						gender = pp3noun.value;
					}
					pp2noun.value = pp1noun.value.substring(0, pp1noun.value.length - 2) + newEnding;
					pp3noun.value = gender;
				}
				
				if(ppid == 2) {
					if(pp2noun.value.endsWith('is')) {
						if(pp1noun.value.endsWith('or')) {
							pp3noun.value = 'm';
						} else if(pp1noun.value.endsWith('tas') || pp1noun.value.endsWith('tudo')) {
							pp3noun.value = 'f';
						} else if(pp1noun.value.endsWith('us') && pp2noun.value.endsWith('utis')) {
						} else if(pp1noun.value.endsWith('o')) {
							pp3noun.value = 'f';
							if(pp2noun.value.endsWith('onis')) {
								pp3noun.value = 'm';
							}
						} else if(pp1noun.value.endsWith('en')) {
							pp3noun.value = 'n';
						}
					}
				}
			}
			
			function radioselect(rButton) {
				document.getElementById("inflectionLabel").innerText = rButton.value.startsWith('a') ? "Inflect an:" : "Inflect a:";
				
				document.getElementById("verbInput").style.display = "none";
				document.getElementById("nounInput").style.display = "none";
				document.getElementById("adjectiveInput").style.display = "none";
				document.getElementById("pronounInput").style.display = "none";
				
				document.getElementById(rButton.value + "Input").style.display = "block";
			}
			
			function getLink(wordKind) {
				src = "https://www.wumbo.co.nz/latinbot/" + wordKind + ".php?";
				
				if(wordKind == "verb") {
					pp1verb = document.getElementById("pp1verb");
					pp2verb = document.getElementById("pp2verb");
					pp3verb = document.getElementById("pp3verb");
					pp4verb = document.getElementById("pp4verb");
					
					src += "pp1=" + pp1verb.value + "&" + "pp2=" + pp2verb.value + "&" + "pp3=" + pp3verb.value + "&" + "pp4=" + pp4verb.value;
					if(cfg.server.enabled) {
						src += "&cfg=" + escape(JSON.stringify(cfg.server.verb));
					}
				} else if(wordKind == "noun") {
					pp1noun = document.getElementById("pp1noun");
					pp2noun = document.getElementById("pp2noun");
					pp3noun = document.getElementById("pp3noun");
					
					src += "pp1=" + pp1noun.value + "&" 
					+ "pp2=" + pp2noun.value + "&" 
					+ "pp3=" + pp3noun.value;
				} else if(wordKind == "adjective") {
					pp1adj = document.getElementById("pp1adj");
					pp2adj = document.getElementById("pp2adj");
					pp3adj = document.getElementById("pp3adj");
					
					src += "pp1=" + pp1adj.value + "&" 
					+ "pp2=" + pp2adj.value + "&" 
					+ "pp3=" + pp3adj.value;
				} else if(wordKind == "pronoun") {
					pronoun = document.getElementById("pronoun");
					
					src += "pp1=" + pronoun.value;
				} else {
					// error!
				}
				
				return src.replace(/ /g, '%20');
			}
			
			function updateFrame(wordKind) {
				src = getLink(wordKind);
				
				xhr = new XMLHttpRequest();
				xhr.open("GET", src, true);
				xhr.onloadend = function() {
					document.getElementById("respFrame").innerHTML = xhr.responseText;
				}
				xhr.send();
			}
			
			function shPermaLink(wordKind) {
				prompt("Copy the text below:", getLink(wordKind));
			}
		//-->
		</script>
	</head>
	<body>
		<span class="head">LatinBot</span>
		<span id="inflectionLabel">Inflect a(n):</span>
		<br>
		<input type="radio" name="wordKind" value="verb" onchange="radioselect(this)">
		<span>Verb</span>
		<br>
		<!--
		<input type="radio" name="wordKind" value="adverb" onchange="radioselect(this)">
		<span>Adverb</span>
		<br>
		-->
		<input type="radio" name="wordKind" value="noun" onchange="radioselect(this)">
		<span>Noun</span>
		<br>
		<input type="radio" name="wordKind" value="adjective" onchange="radioselect(this)">
		<span>Adjective</span>
		<br>
		<input type="radio" name="wordKind" value="pronoun" onchange="radioselect(this)">
		<span>Pronoun</span>
		<br>
		<div id="verbInput" class="input">
			<table>
				<tbody>
					<tr id="vpp1">
						<td>
							<input type="text" id="pp1verb" class="l2inp" placeholder="Pricipal Part I" oninput="verbPPchange(1)">
						</td>
					</tr>
					<tr id="vpp2">
						<td>
							<input type="text" id="pp2verb" class="l2inp" placeholder="Pricipal Part II" oninput="verbPPchange(2)">
						</td>
					</tr>
					<tr id="vpp3">
						<td>
							<input type="text" id="pp3verb" class="l2inp" placeholder="Pricipal Part III" oninput="verbPPchange(3)">
						</td>
					</tr>
					<tr id="vpp4">
						<td>
							<input type="text" id="pp4verb" class="l2inp" placeholder="Pricipal Part IV">
						</td>
					</tr>
				</tbody>
			</table>
			<button onclick="updateFrame('verb')">Update</button><button onclick="shPermaLink('verb')">Get Permalink</button>
		</div>
		<div id="nounInput" class="input">
			<table>
				<tbody>
					<tr>
						<td><input type="text" id="pp1noun" class="l2inp" placeholder="Pricipal Part I" oninput="nounPPchange(1)"></td>
					</tr>
					<tr>
						<td><input type="text" id="pp2noun" class="l2inp" placeholder="Pricipal Part II" oninput="nounPPchange(2)"></td>
					</tr>
					<tr>
						<td>
							<select id="pp3noun">
								<option value="m">Masculine</option>
								<option value="f">Feminine</option>
								<option value="n">Neuter</option>
							</select>
						</td>
					</tr>
				</tbody>
			</table>
			<button onclick="updateFrame('noun')">Update</button><button onclick="shPermaLink('noun')">Get Permalink</button>
		</div>
		<div id="adjectiveInput" class="input">
			<table>
				<tbody>
					<tr id="app1">
						<td>
							<input type="text" id="pp1adj" class="l2inp" placeholder="Pricipal Part I">
						</td>
					</tr>
					<tr id="app2">
						<td>
							<input type="text" id="pp2adj" class="l2inp" placeholder="Pricipal Part II">
						</td>
					</tr>
					<tr id="app3">
						<td>
							<input type="text" id="pp3adj" class="l2inp" placeholder="Pricipal Part III">
						</td>
					</tr>
				</tbody>
			</table>
			<button onclick="updateFrame('adjective')">Update</button><button onclick="shPermaLink('adjective')">Get Permalink</button>
		</div>
		<div id="pronounInput" class="input">
			<select id="pronoun">
				<option selected disabled hidden value="null"></option>
				<optgroup label="Demonstratives">
					<option value="demo1">is, ea, id</option>
					<option value="demo2">hic, haec, hoc</option>
					<option value="demo3">ille, illa, illud</option>
					<!--<option value="demo4">iste, ista, istud</option>-->
				</optgroup>
				<optgroup label="Personals">
					<option value="pers1">ego, mei</option>
					<option value="pers2">tu, tui</option>
					<option value="pers3">-, sui</option>
				</optgroup>
				<optgroup label="Identifying">
					<option value="ident">idem, eadem, idem</option>
				</optgroup>
				<optgroup label="Intensive">
					<option value="intens">ipse, ipsa, ipsum</option>
				</optgroup>
				<optgroup label="Interrogative">
					<option value="interrog">quis, quis, quid</option>
				</optgroup>
				<optgroup label="Relative">
					<option value="rel">qui, quae, quod</option>
				</optgroup>
				<optgroup label="Numbers">
					<option value="num1">unus, una, unum</option>
					<option value="num2">duo, duae, duo</option>
					<option value="num3">tres, tres, tria</option>
				</optgroup>
			</select>
			<button onclick="updateFrame('pronoun')">Update</button><button onclick="shPermaLink('pronoun')">Get Permalink</button>
		</div>
		<div id="respFrame" style="border-style: ridge; padding: 10px; margin: 5px;"><span>Watch this space.....</span></div>
	</body>
</html>
