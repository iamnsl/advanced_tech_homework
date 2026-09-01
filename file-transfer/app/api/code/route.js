import { list } from "@vercel/blob";
import { randomCode } from "@/lib/code";

const MAX_ATTEMPTS = 5;

export async function GET() {
  for (let attempt = 0; attempt < MAX_ATTEMPTS; attempt++) {
    const code = randomCode();
    const { blobs } = await list({ prefix: `transfers/${code}/`, limit: 1 });
    if (blobs.length === 0) {
      return Response.json({ code });
    }
  }
  return Response.json(
    { error: "تعذر توليد كود جديد، حاول مرة أخرى" },
    { status: 500 },
  );
}
