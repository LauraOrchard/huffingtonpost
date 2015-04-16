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
			<li>An Article is an Entity with 6 attributes (ArticleID[pk], ArticleTitle, SectionID, Content, PublishDate, AuthorID)</li>
			<li>The Article is related to the Author via the ArticleID, an Entity with 3 attributes (AuthorID[pk], ArticleTitle, ArticleID)</li>
			<li>If a Reader reads & responds to the Article, the FaceBook login form opens - this is not a database entity, but the FBuniqueID attribute
				is captured for logging "Likes" and "Comments".</li>
			<li>When the Reader "Likes" an article, a weak entity called Likes is created, with 5 attributes (LikeID[pk], ArticleID, LikeCount, FBuniqueID, LikeDate)</li>
			<li>When the Reader "Comments" on at article, a weak entity called Comments is created, with 6 attributes (ParentCommentID[pk], ParentCommentContent, ParentCommentCount,
			ArticleID, ParentCommentDate, FBuniqueID)</li>
			<li>When the Reader makes a comment on a comment, a weak entity called ChildComment is created, with 6 attributes (ChildCommentID[pk], ChildCommentContent, FBuniqueID, ChildCommentCount, ChildCommentDate, ParentCommentID) </li>
			<li>When the Reader "Likes" a comment, a weak entity called CommentLikes is created, with 5 attributes (CommentLikeID[pk], ParentCommentID, CommentLikeCount,
			FBuniquID, CommentLikeDate)</li>
			<li>The reason the FBuniqueID is included in several spots is because a new Reader can choose to "Like a Comment" or "Comment on
				a Comment" as their first interaction with the article.</li>
		</ul>
	</body>
</html>