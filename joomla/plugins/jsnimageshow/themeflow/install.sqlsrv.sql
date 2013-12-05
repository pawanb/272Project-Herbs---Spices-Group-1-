SET QUOTED_IDENTIFIER ON;
IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[#__imageshow_theme_carousel]') AND type in (N'U'))
BEGIN
CREATE TABLE [#__imageshow_theme_carousel](
	[theme_id] [int] IDENTITY(1,1) NOT NULL,
	[image_source] [nvarchar](150) DEFAULT 'thumbnails',
	[image_width] [nvarchar](150) NULL,
	[image_height] [nvarchar](150) NULL,
	[image_border_thickness] [nvarchar](150) DEFAULT '3',
	[image_border_rounded_corner] [nvarchar](150) DEFAULT '2',
	[image_border_color] [nvarchar](150) DEFAULT '#eeeeee',
	[image_effect] [nvarchar](150) DEFAULT 'yes',
	[transparency] [nvarchar](150) DEFAULT '50',
	[background_type] [nvarchar](150) DEFAULT 'transparent',
	[background_color] [nvarchar](150) DEFAULT '#ffffff',
	[container_side_fade] [nvarchar](150) DEFAULT 'white',
	[animation_duration] [nvarchar](150) DEFAULT '1',
	[click_action] [nvarchar](150) DEFAULT 'show_original_image',
	[open_link_in] [nvarchar](150) DEFAULT 'current_browser',
	[orientation] [nvarchar](150) DEFAULT 'horizontal',
	[enable_keyboard_action] [nvarchar](150) DEFAULT 'yes',
	[enable_mouse_wheel_action] [nvarchar](150) DEFAULT 'yes',
	[show_caption] [nvarchar](150) DEFAULT 'yes',
	[caption_background_color] [nvarchar](150) DEFAULT '#000000',
	[caption_opacity] [nvarchar](150) DEFAULT '75',
	[caption_show_title] [nvarchar](150) DEFAULT 'yes',
	[caption_title_css] [nvarchar](255) DEFAULT '',
	[caption_show_description] [nvarchar](150) DEFAULT 'yes',
	[caption_description_length_limitation] [nvarchar](150) DEFAULT '50',
	[caption_description_css] [nvarchar](255) DEFAULT '',
	[auto_play] [nvarchar](150) DEFAULT 'no',
	[slide_timing] [nvarchar](150) DEFAULT '3',
	[pause_on_mouse_over] [nvarchar](150) DEFAULT 'yes',
	CONSTRAINT [PK_#__imageshow_theme_carousel_theme_id] PRIMARY KEY CLUSTERED
(
	[theme_id] ASC
)WITH (STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF)
)
END;