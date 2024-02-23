## Google Text To Speech Library for PHP

The Google TTS Library enables you to work with text to speech via Google API.

### Requirements

PHP 8.2 or higher

### Installation

composer require waglpz/google-tts:"^1.0"

## Authentication with OAuth

1. Follow the instructions to [Create Web Application Credentials](https://github.com/googleapis/google-api-php-client/blob/master/docs/oauth-web.md)
1. Download the JSON credentials in some hidden directory and include this one path in config.
1. Set the path to these credentials using config `authConfig`.
1. Set the scopes required for the API you are going to call using config key `scopes`
1. Set your application's redirect URI in config
1. Set expected prompt when redirect to google. These can `none`, `consent` or `select_account`.
1. In the script handling the redirect URI, exchange the authorization code for an access token:
###### Example 

  ```php
    
  ```

Google documentation
====================

**Examples to createAudio:** https://cloud.google.com/text-to-speech/docs/create-audio

**PHP Example:** https://cloud.google.com/php/docs/reference/cloud-text-to-speech/latest

**Supported Voices and Languages:** https://cloud.google.com/text-to-speech/docs/voices

##### Punctuation
```text
de_de	⏎	neue zeile, zeilenumbruch
de_de	⏎⏎	neuer absatz, neuer abschnitt
de_de	!	Ausrufezeichen, ausrufezeichen, ausrufungszeichen
de_de	"	anführungszeichen, anführungszeichen oben, anführungszeichen unten, gänsefüßchen
de_de	#	doppelkreuz, hash, hash zeichen, hash-zeichen, hashtag, nummernzeichen, raute, rautenzeichen, rautezeichen
de_de	&	et zeichen, et-zeichen, firmen-und, kaufmannsund, kaufmännisches und, und zeichen, und-zeichen
de_de	'	apostroph
einfache anführungszeichen
einfaches anführungszeichen
einfaches anführungszeichen oben
einfaches anführungszeichen unten
einzelnes anführungszeichen
einzelnes anführungszeichen oben
einzelnes anführungszeichen unten
halbe anführungszeichen
halbe anführungszeichen oben
halbe anführungszeichen unten
de_de	(	klammer auf
linke klammer
runde klammer auf
de_de	)	klammer zu
rechte klammer
runde klammer zu
de_de	*	asterisk
malzeichen
sternchen
de_de	,	beistrich
komma
de_de	-	bindestrich
ergänzungsstrich
trennstrich
de_de	.	punkt
de_de	...	auslassungspunkte
auslassungszeichen
punkt punkt punkt
de_de	/	schrägstrich
slash
de_de	:	doppelpunkt
de_de	;	semikolon
strichpunkt
de_de	?	Fragezeichen
fragezeichen
de_de	@	at zeichen
at-zeichen
de_de	[	eckige klammer auf
de_de	\	backslash
umgekehrter schrägstrich
de_de	]	eckige klammer zu
de_de	^	zirkumflex
de_de	_	unterstrich
de_de	{	geschweifte klammer auf
geschwungene klammer auf
de_de	|	längsstrich
pipe
pipe-symbol
senkrechter strich
verkettungszeichen
de_de	}	geschweifte klammer zu
geschwungene klammer zu
de_de	~	tilde
de_de	–	gedankenstrich
```

## Code Quality and Testing ##

To check for coding style violations, run

```
composer waglpz:code:style:check
```

To automatically fix (fixable) coding style violations, run

```
composer waglpz:code:style:fix
```

To check for static type violations, run

```
waglpz:code:analyse
```

To check for regressions, run

```
composer waglpz:test:normal
```

To check all violations at once, run

```
composer waglpz:check:normal
```
