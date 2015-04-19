<!DOCTYPE html>
<html>
	<head lang="en">
		<meta charset="UTF-8">
		<title>Schema for Huffington Post Article</title>
	</head>
	<header><h3>Relationships Between the Entities</h3></header>
	<body>
		<ul>
			<li>Huffington Post does not require a login to read their articles, so the Reader is not an actual entity
				for database purposes <em>until the Reader decides to "Like" or "Comment" on a page.</em></li>
			<li>An Author is an Entity with 4 attributes (AuthorID[pk], AuthorName, AuthorEmail, and AuthorAtHandle)</li>
			<li>The Authors write Articles.</li>
			<li>An Article is an Entity with 4 attributes (ArticleID[pk], ArticleTitle, ArticleContent, and ArticleDate)</li>
			<li>The Article is related to the Author via the Authors_Articles intermediary Entity - a weak entity with 2 attributes (AuthorID and ArticleID[combined PK)</li>
			<li>Sections is an Entity with 2 attributes (SectionID[PK], and SectionName)</li>
			<li>The Articles and Sections are related via the Sections_Articles intermediary Entity - a weak entity with 2 attributes (SectionID and ArticleID[combined PK)</li>
			<li>If a Reader reads and responds to the Article via the FaceBook Profile Entity, which has 3 attributes (FBuniqueID[pk], FBName, and FBEmail) that are
				captured for logging "Likes" and "Comments".</li>
			<li>When the Reader "Likes" an article, an Entity called Likes is created, with 4 attributes (LikeID[pk], ArticleID, FBuniqueID, LikeDate)</li>
			<li>When the Reader "Comments" on an article, an Entity called Comments is created, with 5 attributes (CommentID[pk], CommentContent,
				ArticleID, CommentDate, FBuniqueID)</li>
			<li>When the Reader makes a comment on a comment, a reiterative loop goes back to Comment.</li>
			<li>When the Reader "Likes" a comment, an Entity called CommentLikes is created, with 4 attributes (CommentLikeID[pk], CommentLikeDate, CommentID, and
				FBuniquID)</li>
			<li>The reason the FBuniqueID is included in several spots is because a new Reader can choose to "Like a Comment" or "Comment on
				a Comment" as their first interaction with the article.</li>
		</ul>
		<p>
			<img src="HuffPoCommentERD.pdf" alt="Here is the Huffington Post Comment ERD"/>
		</p>
	</body>
</html>