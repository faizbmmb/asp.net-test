using System.Data.Entity;

public class FeedbackDbContext : DbContext
{
    public FeedbackDbContext() : base("FeedbackDbContext") { }

    public DbSet<Feedback> Feedbacks { get; set; }
}