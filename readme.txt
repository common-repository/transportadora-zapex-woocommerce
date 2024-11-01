=== Transportadora Zapex for WooCommerce ===
Contributors: thallesbrandao
Donate link: http://reatos.com.br/
Tags: shipping, delivery, woocommerce, zapex
Requires at least: 4.0
Tested up to: 5.6
Stable tag: 1.2.2
Requires PHP: 5.6
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Integration between the Zapex and WooCommerce

== Description ==

Utilize os métodos de entrega e serviços dos Zapex com a sua loja WooCommerce.

[Zapex Transportadora](http://www.zapex.com.br/) é uma empresa de transporte brasileira.

Este plugin foi desenvolvido com a autorização da Zapex Transportadora. Nenhum dos desenvolvedores deste plugin possuem vínculos com esta empresa.


= Compatibilidade =

Requer WooCommerce 3.0 ou posterior para funcionar.

== Installation ==

= Instalação do plugin: =

- Envie os arquivos do plugin para a pasta wp-content/plugins, ou instale usando o instalador de plugins do WordPress.
- Ative o plugin.

= Configurações dos produtos =

Se você deseja uma cotação de frete precisa, deve configurar o **peso** e o **tamanho** de todos os produtos. Observe que você pode usar tipos **simples** ou **variáveis** em vez de *virtuais* para configurar produtos (produtos virtuais são ignorados ao fazer cotações). 

Além disso, você pode configurar apenas o peso e deixar o tamanho em branco porque a configuração de **embalagem padrão** será usada (neste caso, o valor do frete pode ter uma pequena alteração porque os correios consideram o peso mais pesado) e Não é o tamanho da citação).

== Frequently Asked Questions ==

= O que eu preciso para utilizar este plugin? =

* WooCommerce 3.0 ou posterior.
* Adicionar peso e dimensões nos produtos que pretende entregar.

= Onde configuro o método de entrega? =

Os método de entrega devem ser configurado em "WooCommerce" > "Configurações" > "Entrega" > "Zapex Transportadora".


= Como resolver o erro "Não existe nenhum método de entrega disponível. Por favor, certifique-se de que o seu endereço esta correto ou entre em contato conosco caso você precise de ajuda."? =

Em primeiro lugar, isso não é um erro, é uma mensagem padrão do WooCommerce, exibida quando nenhum método de entrega é encontrado. 

Mesmo que você tenha configurado os métodos de entrega, quando Zapex retorna uma mensagem de erro (por exemplo, quando o cliente não está na área de cobertura da Zapex ou o peso da embalagem excede o limite permitido), esses métodos de entrega não serão exibidos. No entanto, isso acontece na maioria dos casos porque o método e/ou configuração do produto está incorreta. 

A seguir está uma lista dos erros mais comuns: 

- CEP de origem está faltando no método configurado. 
- CEP de origem inválido. 
- Produtos registrados sem peso e tamanho 
- O peso e o tamanho estão registrados incorretamente (por exemplo, se a configuração for 1000kg, pense que é 1000g, então verifique as configurações de medição em "WooCommerce > Configurações > Produtos")

== Screenshots ==

1. Exemplo da tela de configurações dos método Zapex.
2. Exemplo da tela no carrinho.


== Changelog ==

= 1.0 =
* Initial release

= 1.2 =
* Adicionado calculo por Zona

= 1.2.1 =
* Adicionado dias adicionais ao frete

= 1.2.2 =
* Compativel com versão Woocommerce 5.0.0
