-- 表的结构 `vote_user`
-- 用户表
-- 用户id、学号、姓名、学院、专业、班级、剩余投票数
CREATE TABLE `vote_user` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `xh` varchar(12) NOT NULL,
  `uname` varchar(64) NOT NULL,
  `college` varchar(100) NOT NULL,
  `specialty` varchar(100) NOT NULL,
  `class` varchar(100) NOT NULL,
  `surplus_num` int(1) NOT NULL DEFAULT 5,
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
--
-- 表的结构 `vote_option`
-- 投票选项表
-- id、选项名、选项图片、选项信息、票数
CREATE TABLE `vote_option` (
  `oid` int(11) NOT NULL AUTO_INCREMENT,
  `cid` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  `img` varchar(64) NOT NULL,
  `sinfor` text NOT NULL,
  `infor` mediumtext NOT NULL,
  `votes` int(11) NOT NULL,
  PRIMARY KEY (`oid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
--
-- 表的结构 `vote_event`
-- 投票事件表
-- 事件id、投票用户id、投票选项id、ip地址、时间
CREATE TABLE `vote_event` (
  `eid` int(11) NOT NULL AUTO_INCREMENT,
  `uid` varchar(64) NOT NULL,
  `oid` varchar(64) NOT NULL,
  `ip` varchar(64) NOT NULL,
  `time` varchar(64) NOT NULL,
  PRIMARY KEY (`eid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
--
-- 表的结构 `vote_slide`
-- 幻灯片表
-- id、标题、图片地址、链接、顺序
CREATE TABLE `vote_slide` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(64) NOT NULL,
  `imgurl` varchar(64) NOT NULL,
  `url` varchar(255) NOT NULL,
  `s_order` int(11) NOT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE `vote_cate` (
  `cid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  `c_order` int(11) NOT NULL,
  PRIMARY KEY (`cid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;



INSERT INTO `vote_slide` (`sid`, `title`, `imgurl`, `url`, `s_order`) VALUES
(1, '活动2', '001.jpg', '', 0);

INSERT INTO `vote_cate` (`cid`, `name`, `c_order`) VALUES
(1, '14级', 1),
(2, '15级', 0);

INSERT INTO `vote_option` (`oid`, `cid`,`name`, `img`,`sinfor`,`infor`, `votes`) VALUES
(1, 1, '1小明', 'voteex.jpg','','',0),
(2, 1, '2小明', 'voteex.jpg','','',0),
(3, 1, '3小明', 'voteex.jpg','','',0),
(4, 1, '4小明', 'voteex.jpg','','',0),
(5, 1, '5小明', 'voteex.jpg','','',0),
(6, 2, '6小明', 'voteex.jpg','','',0),
(7, 2, '7小明', 'voteex.jpg','','',0),
(8, 2, '8小明', 'voteex.jpg','','',0),
(9, 2, '9小明', 'voteex.jpg','','',0),
(10, 2, '10小明', 'voteex.jpg','','',0);





