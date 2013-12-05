SET QUOTED_IDENTIFIER ON;
IF EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[#__imageshow_theme_strip]') AND type in (N'U'))
BEGIN
ALTER TABLE [#__imageshow_theme_strip] 
ADD 
  	[open_link_in] [nvarchar](150) DEFAULT 'current_browser'
END;