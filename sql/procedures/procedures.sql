use `webhobru_yii`;

drop procedure if exists `news_count_in_sections`;
drop procedure if exists `current_menu`;
drop procedure if exists `main_menu`;
drop procedure if exists `category_list`;
drop procedure if exists `product_filters_fish`;
drop procedure if exists `product_filters_quote`;
drop procedure if exists `product_index`;
drop procedure if exists `product_view_fish`;
drop procedure if exists `product_view_quote`;
drop procedure if exists `product_list_fish`;
drop procedure if exists `product_list_quote`;

delimiter ;;

create procedure `product_filters_fish`()
begin
	select
		min(`p`.`price`) as `price_min`,
		max(`p`.`price`) as `price_max`
	from
		`product` `p`
	inner join `fish` `f` on `f`.`product_id` = `p`.`id`;
end;;

create procedure `product_filters_quote`()
begin
	select
		min(`p`.`price`) as `price_min`,
		max(`p`.`price`) as `price_max`
	from
		`product` `p`
	inner join `quote` `q` on `q`.`product_id` = `p`.`id`;
end;;

create procedure `category_list`()
begin
	select
		`c`.`id`,
		`c`.`sid`,
		`c`.`header`
	from
		`category` `c`;
end;;

create procedure `product_list_quote`(
	in param_offset int,
    in param_rows int,
    in param_from decimal(8,2),
    in param_to decimal(8,2),
    in param_html tinyint,
    in param_q varchar(32)
)
begin
	select SQL_CALC_FOUND_ROWS
		`p`.`id`,
		`p`.`header`,
		`p`.`price`,
		`c`.`id` as `category_id`,
		`c`.`sid` as `category_sid`,
		`c`.`header` as `category_header`,
		`q`.`html` as `quote_html`,
		`a`.`name` as `author_name`
	from
		`product` `p`
		left join `category` `c` on `c`.`id` = `p`.`category_id`
		inner join `quote` `q` on `q`.`product_id` = `p`.`id`
        left join `author` `a` on `a`.`id` = `q`.`author_id`
	where
		`p`.`price` >= param_from
        and `p`.`price` <= param_to
        and if (param_html < 2, `q`.`html` = param_html, 1)
        and if (char_length(param_q)>2, `q`.`content` like concat('%',param_q,'%'), 1)
	limit param_offset, param_rows;
end;;

create procedure `product_list_fish`(
	in param_offset int,
	in param_rows int,
    in param_from decimal(8,2),
    in param_to decimal(8,2),
    in param_html tinyint,
    in param_strong tinyint,
    in param_em tinyint,
    in param_q varchar(32)
)
begin
	select SQL_CALC_FOUND_ROWS
		`p`.`id`,
		`p`.`header`,
		`p`.`price`,
		`c`.`id` as `category_id`,
		`c`.`sid` as `category_sid`,
		`c`.`header` as `category_header`,
		`f`.`html` as `fish_html`,
		`f`.`strong` as `fish_strong`,
		`f`.`em` as `fish_em`
	from
		`product` `p`
		left join `category` `c` on `c`.`id` = `p`.`category_id`
		inner join `fish` `f` on `f`.`product_id` = `p`.`id`
	where
		`p`.`price` >= param_from
        and `p`.`price` <= param_to
        and if (param_html < 2, `f`.`html` = param_html, 1)
        and if (param_strong < 2, `f`.`strong` = param_strong, 1)
        and if (param_em < 2, `f`.`em` = param_em, 1)
        and if (char_length(param_q)>2, `f`.`content` like concat('%',param_q,'%'), 1)
	limit param_offset, param_rows;
end;;

create procedure `product_view_fish`(in param_id int)
begin
	select 
		`p`.`id`,
		`p`.`header`,
		`p`.`price`,
		`c`.`id` as `category_id`,
		`c`.`sid` as `category_sid`,
		`c`.`header` as `category_header`,
		`f`.`paragraph` as `fish_paragraph`,
		`f`.`html` as `fish_html`,
		`f`.`strong` as `fish_strong`,
		`f`.`em` as `fish_em`,
		`f`.`content` as `fish_content`
	from
		`product` `p`
		left join `category` `c` on `c`.`id` = `p`.`category_id`
		left join `fish` `f` on `f`.`product_id` = `p`.`id`
	where
		`p`.`id` = param_id;
end;;

create procedure `product_view_quote`(in param_id int)
begin
	select 
		`p`.`id`,
		`p`.`header`,
		`p`.`price`,
		`c`.`id` as `category_id`,
		`c`.`sid` as `category_sid`,
		`c`.`header` as `category_header`,
		`q`.`html` as `quote_html`,
		`q`.`content` as `quote_content`,
		`a`.`name` as `author_name`
	from
		`product` `p`
		left join `category` `c` on `c`.`id` = `p`.`category_id`
		left join `quote` `q` on `q`.`product_id` = `p`.`id`
		left join `author` `a` on `a`.`id` = `q`.`author_id`
	where
		`p`.`id` = param_id;
end;;

create procedure `product_index`()
begin
	(
		select 
			`p`.`id`,
			`p`.`header`,
			`p`.`price`,
			`c`.`sid` as `category_sid`,
			`c`.`header` as `category_header`,
			`f`.`paragraph`,
			coalesce(`f`.`html`,`q`.`html`) as `html`,
			`f`.`strong` as `strong`,
			`f`.`em` as `em`,
			`a`.`name` as `author_name`
		from
			`product` `p`
			left join `category` `c` on `c`.`id` = `p`.`category_id`
			left join `fish` `f` on `f`.`product_id` = `p`.`id`
			left join `quote` `q` on `q`.`product_id` = `p`.`id`
			left join `author` `a` on `a`.`id` = `q`.`author_id`
		where
			p.category_id = 1
		order by
			`p`.`id` desc
		limit 0, 3
    )
union
	(
		select 
			`p`.`id`,
			`p`.`header`,
			`p`.`price`,
			`c`.`sid` as `category_sid`,
			`c`.`header` as `category_header`,
			`f`.`paragraph`,
			coalesce(`f`.`html`,`q`.`html`) as `html`,
			`f`.`strong` as `strong`,
			`f`.`em` as `em`,
			`a`.`name` as `author_name`
		from
			`product` `p`
			left join `category` `c` on `c`.`id` = `p`.`category_id`
			left join `fish` `f` on `f`.`product_id` = `p`.`id`
			left join `quote` `q` on `q`.`product_id` = `p`.`id`
			left join `author` `a` on `a`.`id` = `q`.`author_id`
		where
			p.category_id = 2
		order by
			`p`.`id` desc
		limit 0, 3
	);
end ;;

create procedure `news_count_in_sections`()
begin
	select 
		`s`.`id`,
		`s`.`header`,
		count(distinct `n`.`id`) as `countnews`
	from
		`sec_news` `s`
		left join `news` `n` on `n`.`sec` = `s`.`id`
	group by
		`s`.`id`
	order by
		`s`.`id` asc;
end ;;

create procedure `main_menu`()
begin
	(
		select
			`p`.`id`,
			`p`.`pid`,
			`p`.`sid`,
			`p`.`header`,
			`p`.`order`
		from
			`page` `p`
		where
			`p`.`pid` is null
	)
	union
	(
		select
			`c`.`id`,
			`c`.`pid`,
			`c`.`sid`,
			`c`.`header`,
            `c`.`order`
		from `page` `p`
		inner join `page` `c` on `c`.`pid` = p.id
		where `p`.`pid` is null
	)
    order by `order` asc, `id` asc;
end ;;

create procedure `current_menu`(in param_sid varchar(80))
begin
	(
	select
		`c`.`id`,
		`c`.`pid`,
		`c`.`sid`,
		`c`.`header`,
        `c`.`order`
	from
		`page` `p`
	left join
		`page` `r` on `r`.`id` = `p`.`pid`
	left join
		`page` `c` on if(`r`.`id`, `c`.`pid` = `r`.`id`, `c`.`pid` is null)
	where
		`p`.`sid` = param_sid
	)
	union all
	(
	select
		`c2`.`id`,
		`c2`.`pid`,
		`c2`.`sid`,
		`c2`.`header`,
        `c2`.`order`
	from
		`page` `p`
	left join
		`page` `r` on `r`.`id` = `p`.`pid`
	left join
		`page` `c` on if(`r`.`id`, `c`.`pid` = `r`.`id`, `c`.`pid` is null)
	inner join
		`page` `c2` on `c2`.`pid` = `c`.`id`
	where
		`p`.`sid` = param_sid
	)
	order by
		`order` asc,
        `id` asc;
end ;;


-- Example














-- USE `advocat4ru`;
-- DROP procedure IF EXISTS `categories_list`;
-- DROP procedure IF EXISTS `get_category`;
-- DROP procedure IF EXISTS `get_publication`;
-- DROP procedure IF EXISTS `publications_list_on_main`;
-- DROP procedure IF EXISTS `publications_list`;
-- DROP procedure IF EXISTS `sections_list`;
-- DROP procedure IF EXISTS `publications_list_in_section`;
-- DROP procedure IF EXISTS `comments_list`;
-- DROP procedure IF EXISTS `submit_comment`;



-- DELIMITER $$
-- CREATE PROCEDURE `categories_list` ()
-- BEGIN
-- 	SELECT 
-- 		`id`,
-- 		`parentid`,
-- 		`sid`,
-- 		`header`,
-- 		`mainmenushow`,
-- 		`menuheader`
-- 	FROM
-- 		`category`
-- 	WHERE
-- 		`show` = 'true'
-- 	ORDER BY
-- 		`order` ASC,
--         `id` ASC;
-- END$$

-- CREATE PROCEDURE `get_category` (in param_sid varchar(255))
-- BEGIN
-- 	SELECT
-- 		*
-- 	FROM
-- 		`category`
-- 	WHERE 
-- 		`sid` = param_sid;
-- END$$

-- CREATE PROCEDURE `get_publication` (in param_sid varchar(255))
-- BEGIN
-- 	SELECT
-- 		`p`.`id`,
-- 		`p`.`sid`,
-- 		`p`.`header`,
-- 		`p`.`text`,
-- 		`p`.`author`,
--         `p`.`title`,
--         `p`.`description`,
--         `p`.`keywords`,
-- 		CONCAT( DATE_FORMAT(`date`, '%e '), ELT(MONTH(`date`),'января','февраля','марта','апреля','мая','июня','июля','августа','сентября','октября','ноября','декабря'), DATE_FORMAT(`date`, ', %Y')) AS `textdate`
-- 	FROM
-- 		`publications` `p`
-- 	WHERE
-- 		`p`.`sid` = param_sid;
-- END$$

-- CREATE PROCEDURE `publications_list_on_main` ()
-- BEGIN
-- 	SELECT
-- 		`p`.`id`,
-- 		`p`.`sid`,
-- 		`p`.`header`,
-- 		`p`.`intro`,
-- 		`p`.`author`,
-- 		CONCAT( DATE_FORMAT(`date`, '%e '), ELT(MONTH(`date`),'января','февраля','марта','апреля','мая','июня','июля','августа','сентября','октября','ноября','декабря'), DATE_FORMAT(`date`, ', %Y')) AS `textdate`,
--         COUNT(DISTINCT `c`.`id`) AS `commentscount`
-- 	FROM
-- 		`publications` `p`
-- 		left join `comments` `c` on `p`.`id` = `c`.`publication`
-- 	GROUP BY `p`.`id`
-- 	ORDER BY `p`.`date` DESC, p.id DESC
-- 	LIMIT 0, 5;
-- END$$

-- CREATE PROCEDURE `publications_list` (in param_from int, in param_limit int)
-- BEGIN
-- 	SELECT SQL_CALC_FOUND_ROWS
-- 		`p`.`id`,
-- 		`p`.`sid`,
-- 		`p`.`header`,
-- 		`p`.`intro`,
-- 		`p`.`author`,
-- 		CONCAT( DATE_FORMAT(`date`, '%e '), ELT(MONTH(`date`),'января','февраля','марта','апреля','мая','июня','июля','августа','сентября','октября','ноября','декабря'), DATE_FORMAT(`date`, ', %Y')) AS `textdate`,
--         COUNT(DISTINCT `c`.`id`) AS `commentscount`
-- 	FROM
-- 		`publications` `p`
-- 		left join `comments` `c` on `p`.`id` = `c`.`publication`
-- 	GROUP BY `p`.`id`
-- 	ORDER BY `p`.`date` DESC, p.id DESC
-- 	LIMIT param_from, param_limit;
-- END$$

-- CREATE PROCEDURE `publications_list_in_section` (in param_from int, in param_limit int, in param_sid varchar(255))
-- BEGIN
-- 	SELECT SQL_CALC_FOUND_ROWS
-- 		`p`.`id`,
-- 		`p`.`sid`,
-- 		`p`.`header`,
-- 		`p`.`intro`,
-- 		`p`.`author`,
-- 		CONCAT( DATE_FORMAT(`date`, '%e '), ELT(MONTH(`date`),'января','февраля','марта','апреля','мая','июня','июля','августа','сентября','октября','ноября','декабря'), DATE_FORMAT(`date`, ', %Y')) AS `textdate`,
--         COUNT(DISTINCT `c`.`id`) AS `commentscount`
-- 	FROM
-- 		`publications` `p`
-- 		left join `comments` `c` on `p`.`id` = `c`.`publication`
--         inner join `pubsec` `ps` on `ps`.`pub`= `p`.`id`
--         inner join `sections` `s` on `s`.`id` = `ps`.`sec`
-- 	WHERE `s`.`sid` = param_sid
-- 	GROUP BY `p`.`id`
-- 	ORDER BY `p`.`date` DESC, p.id DESC
-- 	LIMIT param_from, param_limit;
-- END$$

-- create PROCEDURE `sections_list` ()
-- BEGIN
-- 	SELECT
-- 		s.*,
--         count(DISTINCT p.id) as countpub
-- 	FROM
-- 		`sections` `s`
-- 		inner join `pubsec` `ps` on `ps`.`sec` = `s`.`id`
--         inner join `publications` `p` on `p`.`id` = `ps`.`pub`
-- 	where `p`.`show` = 'true'
-- 	GROUP BY `s`.`id`
-- 	ORDER BY `s`.`order` ASC;
-- END$$

-- CREATE PROCEDURE `comments_list` (in param_id int)
-- BEGIN
-- 	SELECT
-- 		`c`.`id`,
-- 		`c`.`datatime`,
-- 		`c`.`author`,
-- 		`c`.`text`,
-- 		`c`.`publication`
--     FROM
-- 		`comments` `c`
-- 	WHERE `c`.`publication` = param_id
--     ORDER BY `c`.`datatime` ASC;
-- END$$

-- CREATE PROCEDURE `submit_comment` (in param_name varchar(45), in param_text text, in param_pubid int)
-- BEGIN
-- 	INSERT INTO `comments` (`author`, `text`, `publication`) VALUES (param_name,param_text,param_pubid);
-- END$$


-- DELIMITER ;










-- delimiter ;;
-- create procedure `categories_list`()
-- begin
-- 	select 
-- 		`id`,
-- 		`parentid`,
-- 		`sid`,
-- 		`header`,
-- 		`mainmenushow`,
-- 		`menuheader`
-- 	from
-- 		`category`
-- 	where
-- 		`show` = 'true'
-- 	order by
-- 		`order` asc,
--         `id` asc;
-- end ;;

-- create procedure `comments_list`(in param_id int)
-- begin
-- 	select
-- 		`c`.`id`,
-- 		`c`.`datatime`,
-- 		`c`.`author`,
-- 		`c`.`text`,
-- 		`c`.`publication`
--     from
-- 		`comments` `c`
-- 	where `c`.`publication` = param_id
--     order by `c`.`datatime` asc;
-- end ;;

-- create procedure `get_category`(in param_sid varchar(255))
-- begin
-- 	select
-- 		*
-- 	from
-- 		`category`
-- 	where 
-- 		`sid` = param_sid;
-- end ;;

-- create procedure `get_publication`(in param_sid varchar(255))
-- begin
-- 	select
-- 		`p`.`id`,
-- 		`p`.`sid`,
-- 		`p`.`header`,
-- 		`p`.`text`,
-- 		`p`.`author`,
--         `p`.`title`,
--         `p`.`description`,
--         `p`.`keywords`,
-- 		concat( date_format(`date`, '%e '), elt(month(`date`),'января','февраля','марта','апреля','мая','июня','июля','августа','сентября','октября','ноября','декабря'), date_format(`date`, ', %y')) as `textdate`
-- 	from
-- 		`publications` `p`
-- 	where
-- 		`p`.`sid` = param_sid;
-- end ;;

-- create procedure `publications_list`(in param_from int, in param_limit int)
-- begin
-- 	select sql_calc_found_rows
-- 		`p`.`id`,
-- 		`p`.`sid`,
-- 		`p`.`header`,
-- 		`p`.`intro`,
-- 		`p`.`author`,
-- 		concat( date_format(`date`, '%e '), elt(month(`date`),'января','февраля','марта','апреля','мая','июня','июля','августа','сентября','октября','ноября','декабря'), date_format(`date`, ', %y')) as `textdate`,
--         count(distinct `c`.`id`) as `commentscount`
-- 	from
-- 		`publications` `p`
-- 		left join `comments` `c` on `p`.`id` = `c`.`publication`
-- 	group by `p`.`id`
-- 	order by `p`.`date` desc, p.id desc
-- 	limit param_from, param_limit;
-- end ;;

-- create procedure `publications_list_in_section`(in param_from int, in param_limit int, in param_sid varchar(255))
-- begin
-- 	select sql_calc_found_rows
-- 		`p`.`id`,
-- 		`p`.`sid`,
-- 		`p`.`header`,
-- 		`p`.`intro`,
-- 		`p`.`author`,
-- 		concat( date_format(`date`, '%e '), elt(month(`date`),'января','февраля','марта','апреля','мая','июня','июля','августа','сентября','октября','ноября','декабря'), date_format(`date`, ', %y')) as `textdate`,
--         count(distinct `c`.`id`) as `commentscount`
-- 	from
-- 		`publications` `p`
-- 		left join `comments` `c` on `p`.`id` = `c`.`publication`
--         inner join `pubsec` `ps` on `ps`.`pub`= `p`.`id`
--         inner join `sections` `s` on `s`.`id` = `ps`.`sec`
-- 	where `s`.`sid` = param_sid
-- 	group by `p`.`id`
-- 	order by `p`.`date` desc, p.id desc
-- 	limit param_from, param_limit;
-- end ;;

-- create procedure `publications_list_on_main`()
-- begin
-- 	select
-- 		`p`.`id`,
-- 		`p`.`sid`,
-- 		`p`.`header`,
-- 		`p`.`intro`,
-- 		`p`.`author`,
-- 		concat( date_format(`date`, '%e '), elt(month(`date`),'января','февраля','марта','апреля','мая','июня','июля','августа','сентября','октября','ноября','декабря'), date_format(`date`, ', %y')) as `textdate`,
--         count(distinct `c`.`id`) as `commentscount`
-- 	from
-- 		`publications` `p`
-- 		left join `comments` `c` on `p`.`id` = `c`.`publication`
-- 	group by `p`.`id`
-- 	order by `p`.`date` desc, p.id desc
-- 	limit 0, 5;
-- end ;;

-- create procedure `sections_list`()
-- begin
-- 	select
-- 		s.*,
--         count(distinct p.id) as countpub
-- 	from
-- 		`sections` `s`
-- 		inner join `pubsec` `ps` on `ps`.`sec` = `s`.`id`
--         inner join `publications` `p` on `p`.`id` = `ps`.`pub`
-- 	where `p`.`show` = 'true'
-- 	group by `s`.`id`
-- 	order by `s`.`order` asc;
-- end ;;

-- create procedure `submit_comment`(in param_name varchar(45), in param_text text, in param_pubid int)
-- begin
-- 	insert into `comments` (`author`, `text`, `publication`) values (param_name,param_text,param_pubid);
-- end ;;
-- delimiter ;
