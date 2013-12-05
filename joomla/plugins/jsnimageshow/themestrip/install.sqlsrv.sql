SET QUOTED_IDENTIFIER ON;

IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[#__imageshow_theme_strip]') AND type in (N'U'))
BEGIN
CREATE TABLE [#__imageshow_theme_strip](
	[theme_id] [int] IDENTITY(1,1) NOT NULL,  
	[slideshow_sliding_speed] [nvarchar](150) DEFAULT '500',
	[image_orientation] [nvarchar](150) DEFAULT 'horizontal',
	[image_width] [nvarchar](150) DEFAULT '130',
	[image_height] [nvarchar](150) DEFAULT '130',
	[image_space] [nvarchar](150) DEFAULT '10',
	[image_border] [nvarchar](150) DEFAULT '3',
	[image_rounded_corner] [nvarchar](150) DEFAULT '3',
	[image_shadow] [nvarchar](150) DEFAULT 'no-shadow',
	[image_border_color] [nvarchar](150) DEFAULT '#ccccc',
	[image_click_action] [nvarchar](150) DEFAULT 'no-action',
	[image_source] [nvarchar](150) DEFAULT 'thumbnail',
	[show_caption] [nvarchar](150) DEFAULT 'yes',
	[caption_background_color] [nvarchar](150) DEFAULT '#000000',
	[caption_opacity] [nvarchar](150) DEFAULT '75',
	[caption_show_title] [nvarchar](150) DEFAULT 'yes',
	[caption_title_css] [nvarchar](255) DEFAULT '',
	[caption_show_description] [nvarchar](150) DEFAULT 'yes',
	[caption_description_length_limitation] [nvarchar](150) DEFAULT '50',
	[caption_description_css] [nvarchar](255) DEFAULT '', 
	[container_type] [nvarchar](255) DEFAULT 'elastislide-default',
	[container_border_color] [nvarchar](255) DEFAULT '#cccccc',
	[container_border] [nvarchar](255) DEFAULT '1',
	[container_round_corner] [nvarchar](255) DEFAULT '0',
	[container_background_color] [nvarchar](255) DEFAULT '#ffffff',	
	[container_side_fade] [nvarchar](255) DEFAULT 'white',		
	[open_link_in] [nvarchar](150) DEFAULT 'current_browser',
 CONSTRAINT [PK_#__imageshow_theme_strip_theme_id] PRIMARY KEY CLUSTERED 
(
	[theme_id] ASC
)WITH (STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF)
)
END;