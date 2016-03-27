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
drop procedure if exists `basket_count`;
drop procedure if exists `basket_insert`;
drop procedure if exists `basket_delete`;
drop procedure if exists `basket_list`;
drop procedure if exists `basket_update`;
drop procedure if exists `buy_insert`;
drop procedure if exists `buy_list`;
drop procedure if exists `buy_view`;

delimiter ;;

create procedure `buy_insert`(in param_userid int)
begin

	declare exit handler for sqlexception 
    begin
		rollback;
    end;

    start transaction;

		insert into
			`trade` (`user_id`)
		values
			(param_userid);
		
		insert into
			`check` (`trade_id`, `product_id`, `count`, `full_price`)
		select
			last_insert_id() as `trade_id`,
			`b`.`product_id` as `product_id`,
			`b`.`count` as `count`,
			`p`.`price` * `b`.`count` as `full_price`
		from
			`basket` `b`
		inner join
			`product` `p` on `p`.`id` = `b`.`product_id`
		where
			`b`.`user_id` = param_userid;
            
		delete from `basket` where user_id = param_userid;

	commit;
end;;

create procedure `buy_view`(in param_userid int, in param_tradeid int)
begin
	select
		`p`.`header` as `product_header`
        ,`t`.`content` as `product_content`
        ,`c`.`count` as `product_count`
        ,`cat`.`header` as `category_header`
	from
		`trade` `t`
	inner join
		`check` `c` on `c`.`trade_id` = `t`.`id`
	inner join
		`product` `p` on `p`.`id` = `c`.`product_id`
	inner join
		`category` `cat` on `cat`.`id` = `p`.`category_id`
	inner join
		(
			select `product_id`, `content` from `fish`
			union
            select `product_id`, `content` from `quote`
        ) as `t` on `t`.`product_id` = `p`.`id`
	where
		`t`.`user_id` = param_userid
        and `t`.`id` = param_tradeid;
end;;

create procedure `buy_list`(in param_userid int)
begin
	select
		`t`.`id`,
		`t`.`ts` as `trade_ts`,
		count(c.product_id) as `count_product`,
		sum(c.count) as `count_units`,
        sum(c.full_price) as `total_price`
	from
		`trade` `t`
	inner join
		`check` `c` on `c`.`trade_id` = `t`.`id`
	where
		`t`.`user_id` = param_userid
	group by
		`t`.`id`;
end;;

create procedure `basket_list`(in param_userid int)
begin
	select
        b.count as `basket_count`,
        p.id as `product_id`,
        p.header as `product_header`,
        p.price as `product_price`,
        c.sid as `category_sid`,
        c.header as `category_header`,
        p.price * b.count as `price_sum`
    from
		`user` `u`
	inner join
		`basket` `b` on `b`.`user_id` = `u`.`id`
	inner join
		`product` `p` on `p`.`id` = `b`.`product_id`
	inner join
		`category` `c` on `c`.`id` = `p`.`category_id`
	where 
		`u`.`id` = param_userid;
end;;

create procedure `basket_delete`(in param_userid int, in param_productid int)
begin
	delete from 
		`basket`
	where 
		`basket`.`user_id` = param_userid
        and `basket`.`product_id` = param_productid;
end;;

create procedure `basket_insert`(in param_userid int, in param_productid int, in param_count int)
begin
	insert into
		`basket`(`user_id`,`product_id`,`count`)
	values
		(param_userid, param_productid, param_count)
	on duplicate key update
		`count` = `count` + param_count;
end;;

create procedure `basket_update`(in param_userid int, in param_productid int, in param_count int)
begin
	update
		`basket` `b`
	set
		`b`.`count` = param_count
	where
		`b`.`user_id` = param_userid
        and `b`.`product_id` = param_productid;
end;;

create procedure `basket_count`(in param_userid int, in param_productid int)
begin
	select
        `u`.`id`,
		ifnull(`b`.`count`, 0) as 'count'
	from
		`user` `u`
	left join
		`basket` `b` on `b`.`user_id` = `u`.`id` and `b`.`product_id` = param_productid
	where
		`u`.`id` = param_userid;
end;;

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
