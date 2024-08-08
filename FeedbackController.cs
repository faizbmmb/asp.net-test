using System.Linq;
using System.Web.Mvc;
using YourNamespace.Models; // Change to your namespace

public class FeedbackController : Controller
{
    private FeedbackDbContext db = new FeedbackDbContext();

    // GET: Feedback
    public ActionResult Index()
    {
        return View(db.Feedbacks.ToList());
    }

    // GET: Feedback/Create
    public ActionResult Create()
    {
        return View();
    }

    // POST: Feedback/Create
    [HttpPost]
    [ValidateAntiForgeryToken]
    public ActionResult Create(Feedback feedback, HttpPostedFileBase document)
    {
        if (ModelState.IsValid)
        {
            if (document != null && document.ContentLength > 0)
            {
                using (var reader = new System.IO.BinaryReader(document.InputStream))
                {
                    feedback.Document = reader.ReadBytes(document.ContentLength);
                }
            }

            db.Feedbacks.Add(feedback);
            db.SaveChanges();
            return RedirectToAction("Index");
        }
        return View(feedback);
    }

    // GET: Feedback/Edit/5
    public ActionResult Edit(int id)
    {
        var feedback = db.Feedbacks.Find(id);
        if (feedback == null) return HttpNotFound();
        return View(feedback);
    }

    // POST: Feedback/Edit/5
    [HttpPost]
    [ValidateAntiForgeryToken]
    public ActionResult Edit(Feedback feedback, HttpPostedFileBase document)
    {
        if (ModelState.IsValid)
        {
            if (document != null && document.ContentLength > 0)
            {
                using (var reader = new System.IO.BinaryReader(document.InputStream))
                {
                    feedback.Document = reader.ReadBytes(document.ContentLength);
                }
            }
            db.Entry(feedback).State = EntityState.Modified;
            db.SaveChanges();
            return RedirectToAction("Index");
        }
        return View(feedback);
    }

    // GET: Feedback/Delete/5
    public ActionResult Delete(int id)
    {
        var feedback = db.Feedbacks.Find(id);
        if (feedback == null) return HttpNotFound();
        return View(feedback);
    }

    // POST: Feedback/Delete/5
    [HttpPost, ActionName("Delete")]
    [ValidateAntiForgeryToken]
    public ActionResult DeleteConfirmed(int id)
    {
        var feedback = db.Feedbacks.Find(id);
        db.Feedbacks.Remove(feedback);
        db.SaveChanges();
        return RedirectToAction("Index");
    }
}