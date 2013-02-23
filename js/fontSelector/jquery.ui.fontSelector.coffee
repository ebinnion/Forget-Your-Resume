# jQuery UI Font Selector Widget
#
# Copyright 2012, Olav Andreas Lindekleiv (http://lindekleiv.com/)
# Available under the BSD License
# See the LICENSE file or http://opensource.org/licenses/BSD-3-Clause
#
# Available on BitBucket at
# https://bitbucket.org/lindekleiv/jquery-ui-fontselector

$.widget 'oal.fontSelector',
  options:
    inSpeed: 500
    outSpeed: 250
    bold: false
    italic: false
    underline: false

  _create: ->

    @element.hide()

    # Get list of fonts:
    fonts = []

    for font in @element.children()
      fontLabel = $(font).text()
      fontName = $(font).attr('value')
      @selected = fontName if $(font).attr('selected')
      fonts.push [fontName, fontLabel]

    @selected = fonts[0][0] unless @selected

    @dropdown = $('<div class="fontSelector ui-widget"><span class="handle">&#9660;</span></div>')
    @list = $('<ul class="fonts"></ul>')

    # Load fonts
    for font in fonts
      [font, label] = font
      @element.before "<link rel='stylesheet' type='text/css' href='http://fonts.googleapis.com/css?family=#{font}:400,700,400italic,700italic'></link>"
      fontEl = $("<li style=\"font-family: '#{font}'\">#{label}</li>")
      fontEl.data 'font', font
      if font == @selected
        fontEl.addClass 'selected'
        @dropdown.prepend $("<h4 style=\"font-family: '#{font}'\" class='selected handle'>#{label}</h4>")

      @list.append fontEl

    # Add to page:
    @dropdown.append @list
    @element.after @dropdown

    $('div.fontSelector .handle').click =>
      @_toggleOpen()

  _toggleOpen: ->
    if @list.is(':visible')
      @dropdown.find('span.handle').html '&#9660;'
      @list.slideUp(@options.outSpeed)

    else
      @dropdown.find('span.handle').html '&#9650;'
      @list.slideDown(@options.inSpeed)
      $('div.fontSelector ul.fonts li').click (e) =>
        font = $(e.target).data 'font'
        label = $(e.target).text()
        oldFont = @selected

        return false if font == oldFont

        # Trigger fontChange event:
        @._trigger 'fontChange', null,
          font: font
          oldFont: oldFont

        # Update preview:
        @selected = font
        $('div.fontSelector h4.selected').text(label).css
          fontFamily: font

        for fontLi in @list.children()
          if $(fontLi).data('font') == font
            $(fontLi).addClass 'selected'
          else if $(fontLi).data('font') == oldFont
            $(fontLi).removeClass 'selected'

        # Update select element:
        for fontOption in @element.children()
          fontName = $(fontOption).val()
          if fontName == font
            $(fontOption).attr('selected', 'selected')

  _setOption: (key, value) ->
    # Update previews when bold/italic/underline is enabled/disabled:
    if key == 'bold' and value in [true, false]
      @options.bold = value
      if value == true
        @dropdown.find('h4.selected').css {fontWeight: 'bold'}
        @list.css {fontWeight: 'bold'}
      else
        @dropdown.find('h4.selected').css {fontWeight: 'normal'}
        @list.css {fontWeight: 'normal'}

    else if key == 'italic' and value in [true, false]
      @options.italic = value
      if value == true
        @dropdown.find('h4.selected').css {fontStyle: 'italic'}
        @list.css {fontStyle: 'italic'}
      else
        @dropdown.find('h4.selected').css {fontStyle: 'normal'}
        @list.css {fontStyle: 'normal'}

    else if key == 'underline' and value in [true, false]
      @options.underline = value
      if value == true
        @dropdown.find('h4.selected').css {textDecoration: 'underline'}
        @list.css {textDecoration: 'underline'}
      else
        @dropdown.find('h4.selected').css {textDecoration: 'none'}
        @list.css {textDecoration: 'none'}

    if key in ['bold', 'italic', 'underline'] and value in [true, false]
      # Trigger styleChange event:
      @._trigger 'styleChange', null,
        style: key
        value: value

  destroy: ->
    Widget::destroy.call @